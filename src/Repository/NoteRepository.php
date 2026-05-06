<?php

namespace App\Repository;

use App\Entity\Note;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Note>
 */
class NoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    public function getNoteByAudiovisuelId(int $id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT utilisateur.username as utilisateur, note.utilisateur_id as utilisateur_id, note.id as id, note, commentaire, date_creation FROM note INNER JOIN utilisateur ON note.utilisateur_id = utilisateur.id WHERE note.audiovisuel_id = ? ORDER BY date_creation DESC LIMIT 10';

        return $conn->fetchAllAssociative($sql, [$id]);
    }
}
