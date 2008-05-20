<?php
abstract class AbstractNode
{

  public $uri;
  public $properties;
  
  abstract public function getNode();
  abstract public function setNode();
  abstract public function copyNode();
  abstract public function moveNode();
  abstract public function deleteNode();

}
?>

<?php
abstract class AbstractDataNode extends AbstractNode
{

  public $accepts;
  public $provides;
  public $busy;
  public $capabilities;

}
?>