<?php
namespace App\Command;

use App\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Service\GenerateToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command
{
    private $encoder;
    private $token;
    private $objectManager;
    public function __construct(ObjectManager $objectManager, GenerateToken $token, UserPasswordEncoderInterface $encoder)
    {
        parent::__construct();
        $this->objectManager = $objectManager;
        $this->token = $token;
        $this->encoder = $encoder;
    }
    protected function configure()
    {
        $this
            ->setName('user:create')
            ->setDescription('Create an user.')
            ->setHelp('This command allow you to create an user.')
            ->setDefinition(array(
                new InputArgument('firstname', InputArgument::REQUIRED, 'The firstname'),
                new InputArgument('lastname', InputArgument::REQUIRED, 'The lastname'),
                new InputArgument('email', InputArgument::REQUIRED, 'The email'),
                new InputArgument('password', InputArgument::REQUIRED, 'The password'),
                new InputArgument('city', InputArgument::REQUIRED, 'The city'),
                new InputArgument('address', InputArgument::REQUIRED, 'The address'),
            ))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            '==============================',
            '        Create an User        ',
            '==============================',
            '',
        ]);

        $email = $input->getArgument('email');
        if ($user = $this->objectManager->getRepository(User::class)->findOneBy(["email" => $email])) {
            throw new \Exception('User already exist.');
        }

        $user = new User();
        $user->setFirstname($input->getArgument('firstname'));
        $user->setLastname($input->getArgument('lastname'));
        $user->setEmail($email);
        $encoded = $this->encoder->encodePassword($user, $input->getArgument('password'));
        $user->setPassword($encoded);
        $user->setCity($input->getArgument('city'));
        $user->setAddress($input->getArgument('address'));
        $user->setIsActive(true);
        $user->setRoles("{\"roles\": \"ROLE_USER\" }");
        $user->setToken($this->token->generateToken());

        $this->objectManager->persist($user);
        $this->objectManager->flush();

        $output->writeln("<comment>User " . $input->getArgument('firstname') . " created ");
    }
}