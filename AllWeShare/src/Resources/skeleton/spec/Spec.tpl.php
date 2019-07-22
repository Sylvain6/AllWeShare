<?= "<?php\n"; ?>

namespace <?= $namespace; ?>;

use App\Entity\<?= $entity_name; ?>;
use PhpSpec\ObjectBehavior;

class <?= $class_name; ?> extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(<?= $entity_name; ?>::class);
    }

    public function it_has_an_id_getter()
    {
        $this->getId()->shouldBeNull();
    }

<?php foreach ($methods as $method) : ?>
<?php if ($method['setter']) : ?>
    public function <?= $method['it_has_setter']; ?>()
    {
<?php if (\is_array($method['setter'])) : ?>
        $this-><?= $method['setter']['adder']; ?>(<?= $method['value']; ?>);
        $this-><?= $method['setter']['remover']; ?>(<?= $method['value']; ?>);
<?php else : ?>
        $this-><?= $method['setter']; ?>(<?= $method['value']; ?>);
<?php endif; ?>
    }

    public function <?= $method['it_has']; ?>()
    {
        $value = <?= $method['value']; ?>;
<?php if (\is_array($method['setter'])) : ?>
        $this-><?= $method['setter']['adder']; ?>($value);
        $this-><?= $method['getter']; ?>()->shouldBeAnInstanceOf('Doctrine\Common\Collections\ArrayCollection');
<?php else : ?>
        $this-><?= $method['setter']; ?>($value);
        $this-><?= $method['getter']; ?>()->shouldReturn($value);
<?php endif; ?>
    }
<?php endif; ?>
<?php endforeach; ?>
}