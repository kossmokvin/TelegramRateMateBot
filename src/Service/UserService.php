<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    private $userRepository;
    private $entityManager;

    private $tgInitData;


    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager, TelegramService $telegramService)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;

        $this->tgInitData = $telegramService->getInitData();
    }

    /**
     * Get user by ID
     *
     * @param int $id
     * @param array $tgInitData {
     *    array $user {
     *        string $username
     *        string $first_name
     *        string $last_name
     *    }
     * }
     * @return User|null
     */
    public function get(int $id)
    {
        // Find user by ID
        $user = $this->userRepository->find($id);

        // Create new user DB record if it doesn't exist
        if ($user === null) {
            $user = $this->create((int) $id);
        }

        return $user;
    }

    /**
     * Create a new user record with the specified ID
     *
     * @param int $id
     * @return User
     */
    public function create(int $id): User
    {
        $username = $this->tgInitData['user']['username'] ?? "";
        $firstname = $this->tgInitData['user']['first_name'] ?? "";
        $lastname = $this->tgInitData['user']['last_name'] ?? "";

        $user = new User();
        $user->setId($id);
        $user->setUsername($username);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
