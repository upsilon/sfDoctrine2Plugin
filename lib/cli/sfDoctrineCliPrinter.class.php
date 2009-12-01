<?php

use Doctrine\Common\Cli\Printers\AnsiColorPrinter;

class sfDoctrineCliPrinter extends AnsiColorPrinter
{
  protected $formatter;

  public function setFormatter($formatter)
  {
    $this->formatter = $formatter;
  }

  public function write($message, $style = 'NONE')
  {
    fwrite($this->_stream, $this->format($message, $style));
    
    return $this;
  }

  public function writeln($message, $style = 'NONE')
  {
    $messages = explode("\n", $message);
    foreach ($messages as $message)
    {
      $this->write($this->formatter->formatSection('doctrine', $this->format($message.PHP_EOL, $style)));
    }
  }
}