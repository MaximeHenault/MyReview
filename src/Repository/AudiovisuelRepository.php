<?php

namespace App\Repository;

use App\Entity\Audiovisuel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\ParameterType;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Audiovisuel>
 */
class AudiovisuelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Audiovisuel::class);
    }

    //Récupère les films avec une pagination
    public function getPaginationFilm(int $page = 1, int $limite = 15): array
    {
        $page = max(1, $page);
        $start = ($page - 1) * $limite;

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT a.*,
                   ROUND(COALESCE(AVG(n.note), 0) * 2) / 2 AS note_arrondie,
                   COUNT(n.note) as nb_note
            FROM audiovisuel a
            LEFT JOIN note n ON n.audiovisuel_id = a.id
            WHERE a.type_audiovisuel_id = :typeId
            GROUP BY a.id
            ORDER BY note_arrondie DESC
            LIMIT :limite OFFSET :start
        ';

        $rows = $conn->executeQuery(
            $sql,
            [
                'typeId' => 1,
                'limite' => $limite,
                'start' => $start,
            ],
            [
                'typeId' => ParameterType::INTEGER,
                'limite' => ParameterType::INTEGER,
                'start' => ParameterType::INTEGER,
            ]
        )->fetchAllAssociative();

        $countSql = '
            SELECT COUNT(DISTINCT a.id) AS total
            FROM audiovisuel a
            LEFT JOIN note n ON n.audiovisuel_id = a.id
            WHERE a.type_audiovisuel_id = :typeId
        ';

        $total = (int) $conn->fetchOne(
            $countSql,
            ['typeId' => 1],
            ['typeId' => ParameterType::INTEGER]
        );
        $pages = max(1, (int) ceil($total / $limite));

        return [
            'films' => $rows,
            'total' => $total,
            'page' => $page,
            'pages' => $pages,
        ];
    }

    //Récupère les animés avec une pagination
    public function getPaginationSerieAnime(int $page = 1, int $limite = 15, int $typeId): array
    {
        $page = max(1, $page);
        $start = ($page - 1) * $limite;

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT a.*,
                (SELECT ROUND(COALESCE(AVG(n.note), 0) * 2) / 2
                    FROM note n
                    WHERE n.audiovisuel_id = a.id) AS note_arrondie,
                (SELECT COUNT(*)
                    FROM saison s
                    WHERE s.audiovisuel_id = a.id) AS nb_saisons,
                (SELECT SUM(nb_episode)
                    FROM saison s
                    WHERE s.audiovisuel_id = a.id) AS nb_episodes
            FROM audiovisuel a
            WHERE a.type_audiovisuel_id = :typeId
            ORDER BY note_arrondie DESC
            LIMIT :limite OFFSET :start
        ';

        $rows = $conn->executeQuery(
            $sql,
            [
                'typeId' => $typeId,
                'limite' => $limite,
                'start' => $start,
            ],
            [
                'typeId' => \Doctrine\DBAL\ParameterType::INTEGER,
                'limite' => \Doctrine\DBAL\ParameterType::INTEGER,
                'start' => \Doctrine\DBAL\ParameterType::INTEGER,
            ]
        )->fetchAllAssociative();

        $countSql = '
            SELECT COUNT(*) AS total
            FROM audiovisuel a
            WHERE a.type_audiovisuel_id = :typeId
        ';

        $total = (int) $conn->fetchOne($countSql, ['typeId' => $typeId], ['typeId' => \Doctrine\DBAL\ParameterType::INTEGER]);
        $pages = max(1, (int) ceil($total / $limite));

        if ($typeId == 2)
        {
            return [
            'series' => $rows,
            'total' => $total,
            'page' => $page,
            'pages' => $pages,
        ];
        }
        else
        {
            return [
            'animes' => $rows,
            'total' => $total,
            'page' => $page,
            'pages' => $pages,
        ];
        }

        
    }

    //Récupère un audiovisuel à partir de son ID.
    public function getAudiovisuelById(int $id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT * FROM audiovisuel WHERE id = ?';

        return $conn->fetchAllAssociative($sql, [$id]);
    }

    public function getStats(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT 
                (SELECT COUNT(*) FROM audiovisuel WHERE type_audiovisuel_id = 1) AS total_films,
                (SELECT COUNT(*) FROM audiovisuel WHERE type_audiovisuel_id = 2) AS total_series,
                (SELECT COUNT(*) FROM audiovisuel WHERE type_audiovisuel_id = 3) AS total_animes,
                (SELECT COUNT(*) FROM note) AS total_notes
        ";

        $result = $conn->executeQuery($sql);

        return $result->fetchAssociative();
    }

    public function searchByTitle(string $query): array
    {
        return $this->createQueryBuilder('a')
            ->where('a.title LIKE :start')
            ->orWhere('a.title LIKE :contain')
            ->setParameter('start', $query . '%')     // priorité
            ->setParameter('contain', '%' . $query . '%')
            ->setMaxResults(5)
            ->orderBy('a.title', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
 
