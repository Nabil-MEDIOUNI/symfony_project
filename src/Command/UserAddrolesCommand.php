<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserAddrolesCommand extends Command
{
    protected static $defaultName = 'app:user:addroles';
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Modifier un utilisateur en lui ajoutant de nouveaux rôles')
            ->addArgument('email', InputArgument::REQUIRED, 'Email tu veux le modifié')
            ->addArgument('roles', null, InputArgument::REQUIRED, "Le role tu veux l'ajouté");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $roles = $input->getArgument('roles');
        $userRepository = $this->em->getRepository(User::class);
        $user = $userRepository->findOneBy(['email' => $email]);

        if ($user) {
            $user->addRoles($roles);
            $this->em->flush();
            $io->success('The role is added to the user!');
        }

        else {
            $io->error('Something wrong hapenned!');
        }

        return 0;
    }
}
