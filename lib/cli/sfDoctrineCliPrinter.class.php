<?php

use Doctrine\ORM\Tools\Cli\Printers\AnsiColorPrinter;

class sfDoctrineCliPrinter extends AnsiColorPrinter
{
  protected $formatter;

  public function setFormatter($formatter)
  {
    $this->formatter = $formatter;
  }

  public function write($message, $style = 'NONE')
  {
    $style = is_string($style) ? $this->getStyle($style) : $style;

    fwrite($this->_stream, $this->format($message, $style));
    
    return $this;
  }

  public function writeln($message, $style = 'NONE')
  {
    if ($message == 'Doctrine Command Line Interface')
    {
      return $this;
    }

    return $this->write($this->formatter->formatSection('doctrine', $message).PHP_EOL, $style);
  }
}