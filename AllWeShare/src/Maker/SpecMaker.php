<?php
namespace App\Maker;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Bundle\MakerBundle\Util\ClassNameDetails;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

class SpecMaker extends AbstractMaker
{
    /** @var EntityManagerInterface */
    private $em;
    /**
     * SpecMaker constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * Return the command name for your maker (e.g. make:report).
     *
     * @return string
     */
    public static function getCommandName(): string
    {
        return 'make:spec';
    }
    /**
     * Configure the command: set description, input arguments, options, etc.
     *
     * By default, all arguments will be asked interactively. If you want
     * to avoid that, use the $inputConfig->setArgumentAsNonInteractive() method.
     *
     * @param Command            $command
     * @param InputConfiguration $inputConfig
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig)
    {
        $command
            ->setDescription('Creates automatically spec files')
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                sprintf(
                    'Class name of the entity to test (e.g. <fg=yellow>%s</>)',
                    Str::asClassName(Str::getRandomTerm())
                )
            )
            // ->setHelp(file_get_contents(__DIR__.'/../Resources/help/MakeEntity.txt'))
        ;
        $inputConfig->setArgumentAsNonInteractive('name');
    }
    /**
     * Configure any library dependencies that your maker requires.
     *
     * @param DependencyBuilder $dependencies
     */
    public function configureDependencies(DependencyBuilder $dependencies)
    {
        // TODO: Implement configureDependencies() method.
    }
    /**
     * Called after normal code generation: allows you to do anything.
     *
     * @param InputInterface $input
     * @param ConsoleStyle   $io
     * @param Generator      $generator
     *
     * @throws \Exception
     */
    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator)
    {
        $name = $input->getArgument('name');
        if ($name) {
            $this->genSpec($name, $generator);
        } else {
            $meta = $this->em->getMetadataFactory()->getAllMetadata();
            foreach ($meta as $m) {
                $this->genSpec(str_replace('App\\Entity\\', '', $m->getName()), $generator);
            }
        }
        $generator->writeChanges();
        $this->writeSuccessMessage($io);
    }
    private function genSpec($name, $generator)
    {
        $class = 'App\\Entity\\'.$name;
        $entity = new $class();
        $specClassNameDetails = $this->createClassNameDetails($name);
        $properties = $this->getPropertyNames($entity);
        $methods = $this->getMethods($entity, $properties);
        $generator->generateClass(
            $specClassNameDetails->getFullName(),
            'src/Resources/skeleton/spec/Spec.tpl.php',
            [
                'entity_name' => $name,
                'methods' => $methods,
            ]
        );
    }
    private function createClassNameDetails($name): ClassNameDetails
    {
        $fullNamespacePrefix = 'spec\\App\\Entity';
        $suffix = 'Spec';
        if ('\\' === $name[0]) {
            $className = substr($name, 1);
        } else {
            $className = rtrim($fullNamespacePrefix, '\\').'\\'.Str::asClassName($name, $suffix);
        }
        return new ClassNameDetails($className, $fullNamespacePrefix, $suffix);
    }
    private function getPropertyNames($class): array
    {
        $reflClass = new \ReflectionClass($class);
        return array_map(function (\ReflectionProperty $prop) {
            return $prop->getName();
        }, $reflClass->getProperties());
    }
    private function getMethods($entity, array $properties)
    {
        return array_map(function ($property) use ($entity) {
            $data = [
                'property' => $property,
                'getter' => null,
            ];
            if (method_exists($entity, 'get'.Str::asCamelCase($property))) {
                $data['getter'] = 'get'.Str::asCamelCase($property);
            } elseif ('is'.Str::asCamelCase($property)) {
                $data['getter'] = 'is'.Str::asCamelCase($property);
            }
            $data['it_has'] = sprintf('it_has_a_%s', Str::asSnakeCase($property));
            $type = (new \ReflectionMethod($entity, $data['getter']))->getReturnType();
            $data['value'] = $this->getRandomValue($type, $entity);
            if (!$type) {
                return null;
            }
            if ('Doctrine\\Common\\Collections\\Collection' === $type->getName()) {
                $singularProperty = Str::pluralCamelCaseToSingular($property);
                $adder = 'add'.Str::asCamelCase($singularProperty);
                $adder = method_exists($entity, $adder) ? $adder : null;
                $remover = 'remove'.Str::asCamelCase($singularProperty);
                $remover = method_exists($entity, $remover) ? $remover : null;
                $data['value'] = 'new \\'.(new \ReflectionMethod($entity, $adder))->getParameters()[0]->getType()->getName().'()';
                $data['setter'] = compact('adder', 'remover');
            } else {
                $setter = 'set'.Str::asCamelCase($property);
                $data['setter'] = method_exists($entity, $setter) ? $setter : null;
            }
            $data['it_has_setter'] = sprintf('it_has_a_%s_setter', Str::asSnakeCase($property));
            return $data;
        }, $properties);
    }
    private function getRandomValue(?string $type, $entity = null)
    {
        if (0 === strncmp($type, 'App\\Entity\\', 11)) {
            return 'new \\'.$type.'()';
        }
        switch ($type) {
            case 'string':
                return "''";
            case 'int':
                return 10;
            case 'bool':
                return 'false';
            case 'DateTime':
            case 'DateTimeInterface':
                return 'new \DateTime()';
            case 'self':
                return 'new \\'.get_class($entity).'()';
            default:
                return null;
        }
    }
}