<?php
/**
 * Created by PhpStorm.
 * User: jkuprijanovs
 * Date: 2/24/2017
 * Time: 1:30 AM
 */

namespace WebJaros\SymfonyLogReaderBundle\Parser;


use WebJaros\SymfonyLogReaderBundle\Entity\Record;

class LineParser
{
    /**
     * @var string
     */
    private $line;

    /**
     * @var Record
     */
    private $record = null;

    /**
     * @param string $line
     * @return LineParser
     */
    public function setLine(string $line): LineParser
    {
        $this->line = $line;
        return $this;
    }

    /**
     * @return Record
     */
    public function parse(): Record
    {
        $this
            ->setRecord()
            ->parseCreatedAt()
            ->parseChannel()
            ->parseLevelAndMessage()
        ;
        return $this->record;
    }

    /**
     * @return LineParser
     */
    public function setRecord(): LineParser
    {
        $this->record = new Record();
        return $this;
    }

    /**
     * @return LineParser
     */
    private function parseCreatedAt(): LineParser
    {
        $this->record->setCreatedAt(
            new \DateTime(
                substr($this->line, 1, 19)
            )
        );

        $this->line = substr($this->line, 22);

        return $this;
    }

    /**
     * @return LineParser
     */
    private function parseChannel(): LineParser
    {
        $end = strpos($this->line, '.');
        $this->record->setChannel(
            substr(
                $this->line,
                0,
                $end
            )
        );

        $this->line = substr($this->line, $end + 1);

        return $this;
    }

    /**
     * @return LineParser
     */
    private function parseLevelAndMessage(): LineParser
    {
        $end = strpos($this->line, ': ');
        $this->record->setLevel(
            substr(
                $this->line,
                0,
                $end
            )
        );

        $this->record->setMessage(
            substr(
                $this->line,
                $end + 2
            )
        );

        return $this;
    }

}