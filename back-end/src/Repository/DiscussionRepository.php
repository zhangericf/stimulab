<?php

namespace App\Repository;

use App\Entity\Discussion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Discussion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Discussion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Discussion[]    findAll()
 * @method Discussion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscussionRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct
    (
        ManagerRegistry $registry,
        EntityManagerInterface $manager
    )
    {
        parent::__construct($registry, Discussion::class);
        $this->manager = $manager;
    }

    public function saveDiscussion($username, $theme, $state, $message)
    {
        $newDiscussion = new Discussion();

        $newDiscussion
            ->setUsername($username)
            ->setTheme($theme)
            ->setState($state)
            ->setMessage($message);

        $this->manager->persist($newDiscussion);
        $this->manager->flush();
    }

    public function modifyDiscussion($modifiedDiscussion)
    {
        $this->manager->persist($modifiedDiscussion);
        $this->manager->flush();
    }

    public function deleteDiscussion($discussion)
    {
        $this->manager->remove($discussion);
        $this->manager->flush();
    }

    public function transform(Discussion $discussion) {
        return [
            'id' => $discussion->getId(),
            'username' => $discussion->getUsername(),
            'theme' => $discussion->getTheme(),
            'state' => $discussion->getState(),
            'message' => $discussion->getMessage()
        ];
    }

    public function transformArray($discussions) {
        $tmp = [];
        foreach ($discussions as $discussion) {
            array_push($tmp, $this->transform($discussion));
        }
        return $tmp;
    }

    // /**
    //  * @return Discussion[] Returns an array of Discussion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Discussion
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
