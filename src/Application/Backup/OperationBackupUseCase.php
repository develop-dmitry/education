<?php

declare(strict_types=1);

namespace App\Application\Backup;

use App\Application\Exception\FileNotFoundException;
use App\Domain\Operation\Operation;
use App\Domain\Operation\OperationBackup;
use App\Domain\Operation\OperationNotFoundException;
use App\Domain\Operation\OperationRepository;
use XMLReader;
use XMLWriter;

class OperationBackupUseCase implements OperationBackup
{
    public function __construct(
        private readonly OperationRepository $operationRepository
    ) {
    }

    public function dump(string $path): void
    {
        $writer = new XMLWriter();
        $writer->openUri($path);
        $writer->setIndent(true);
        $writer->startDocument();
        $writer->startElement('Operations');

        $operations = $this->operationRepository->findAll();

        foreach ($operations as $operation) {
            $writer->startElement('Operation');

            foreach ($operation->toArray() as $key => $item) {
                $writer->writeElement($key, (string) $item);
            }

            $writer->endElement();
        }

        $writer->endElement();
        $writer->endDocument();
        $writer->flush();
    }

    public function import(string $path): void
    {
        if (!file_exists($path)) {
            throw new FileNotFoundException("File by path \"$path\" not found");
        }

        $operations = $this->getOperationsFromXML($path);

        foreach ($operations as $operation) {
            $this->operationRepository->save($operation);
        }
    }

    /**
     * @return Operation[]
     * @throws OperationNotFoundException
     */
    protected function getOperationsFromXML(string $path): array
    {
        $reader = new XMLReader();
        $reader->open($path);
        $elements = $this->parse($reader);
        $reader->close();

        if (empty($elements)) {
            throw new OperationNotFoundException("Operations in \"$path\" not found");
        }

        $operations = [];

        foreach ($elements[0]['children'] as $operation) {
            $data = [];

            foreach ($operation['children'] as $child) {
                $data[$child['tag']] = $child['children']['text'];
            }

            $operations[] = Operation::fromArray($data);
        }

        return $operations;
    }

    protected function parse(XMLReader $reader): array
    {
        $tree = [];

        while ($reader->read()) {
            if ($reader->nodeType === XMLReader::END_ELEMENT) {
                return $tree;
            }

            if ($reader->nodeType === XMLReader::ELEMENT) {
                $node = [];

                $node['tag'] = $reader->name;

                if (!$reader->isEmptyElement) {
                    $node['children'] = $this->parse($reader);
                }

                $tree[] = $node;
            } else if ($reader->nodeType === XMLReader::TEXT) {
                $tree = ['text' => $reader->value];
            }
        }

        return $tree;
    }
}