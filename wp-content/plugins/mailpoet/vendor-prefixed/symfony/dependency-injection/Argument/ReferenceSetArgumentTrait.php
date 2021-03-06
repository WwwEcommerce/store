<?php
namespace MailPoetVendor\Symfony\Component\DependencyInjection\Argument;
if (!defined('ABSPATH')) exit;
use MailPoetVendor\Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use MailPoetVendor\Symfony\Component\DependencyInjection\Reference;
trait ReferenceSetArgumentTrait
{
 private $values;
 public function __construct(array $values)
 {
 $this->setValues($values);
 }
 public function getValues()
 {
 return $this->values;
 }
 public function setValues(array $values)
 {
 foreach ($values as $k => $v) {
 if (null !== $v && !$v instanceof Reference) {
 throw new InvalidArgumentException(\sprintf('A "%s" must hold only Reference instances, "%s" given.', __CLASS__, \is_object($v) ? \get_class($v) : \gettype($v)));
 }
 }
 $this->values = $values;
 }
}
