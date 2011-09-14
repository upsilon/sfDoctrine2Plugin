<?php
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterInterface;

class sfDoctrineCliPrinter implements OutputInterface
{
  protected $formatter;
  protected $dispatcher;

  public function setFormatter(OutputFormatterInterface $formatter)
  {
  }

  public function getFormatter()
  {
  }

  public function setSymfonyFormatter(sfFormatter $formatter)
  {
    $this->formatter = $formatter;
  }

  public function setDispatcher($dispatcher)
  {
    $this->dispatcher = $dispatcher;
  }

  public function logSection($section, $message, $size = null, $style = 'INFO')
  {
    $this->dispatcher->notify(new sfEvent($this, 'command.log', array($this->formatter->formatSection($section, $message, $size, $style))));
  }

  /**
   * Writes a message to the output.
   *
   * @param string|array $messages The message as an array of lines of a single string
   * @param Boolean      $newline  Whether to add a newline or not
   * @param integer      $type     The type of output
   */
  public function write($messages, $newline = false, $type = 0)
  {
    $this->logSection("Doctrine", $messages);
    return $this;
  }

  public function writeln($messages, $type = 0)
  {
    return $this->write($messages, true, $type);
  }

  public function setVerbosity($level)
  {
  }

  public function getVerbosity()
  {
  }

  public function setDecorated($decorated)
  {
  }

  public function isDecorated()
  {
  }
}
