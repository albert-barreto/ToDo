<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $password_encoder)
    {
        $this->password_encoder = $password_encoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$firstName, $lastName, $email, $password, $roles])
        {
            $user = new User();
            $user->setFirstname($firstName);
            $user->setLastName($lastName);
            $user->setEmail($email);
            $user->setPassword($this->password_encoder->encodePassword($user, $password));
            $user->setRoles($roles);

            $manager->persist($user);
        }
        $manager->flush();
    }

    private function getUserData(): array
    {
        return [

            ['Albert', 'Einstein', 'a@todo.com', 'pass123', ['ROLE_ADMIN']],
            ['Isaac', 'Newton', 'i@todo.com', 'pass123', ['ROLE_ADMIN']],
            ['Galileo', 'Galilei', 'g@todo.com', 'pass123', ['ROLE_USER']],
            ['Marie', 'Curie', 'm@todo.com', 'pass123', ['ROLE_USER']]
        ];
    }
}
