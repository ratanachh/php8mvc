<?php
declare(strict_types=1);

namespace QuickSoft\File;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class Directory
{
    protected string $document_root;
    protected string $request_uri;
    protected string $filename;
    private array $tokenCounts = [];
    protected RecursiveIteratorIterator $files;

    public function __construct(string $filename){
        $this->document_root = str_replace(DS, '/', $_SERVER['DOCUMENT_ROOT']);
        $this->filename = str_replace(DS, '/', $filename);
        $this->request_uri = $_SERVER['REQUEST_URI'];
    }

    public function scanFiles($path): Directory
    {
        $dirIterator = new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS);
        $this->files = new RecursiveIteratorIterator($dirIterator);
        return $this;
    }

    public function getFileCount(): int
    {
        return iterator_count($this->files);
    }

    public function getClassControllerNameArray(): array
    {
        $classes = [];
        foreach ($this->files as $file) {
            if ($file->getExtension() == 'php') {
                $classes[] = pathinfo(basename($file->getFilename()), PATHINFO_FILENAME);
//                $classes[] = str_replace('.php', '', $file->getFilename());

            }
        };
        return $classes;
    }

    /**
     * @return string
     */
    public function getAbsoluteUri() : string
    {
        return str_replace($this->getSubDirectory(), '', $this->request_uri);
    }

    /**
     * @return string
     */
    public function getSubDirectory() : string
    {
        return str_replace($this->document_root, '', $this->filename);
    }

    /**
     * @return string|string[]
     */
    public function getDocumentRoot(): array|string
    {
        return $this->document_root;
    }

    /**
     * @param string|string[] $document_root
     */
    public function setDocumentRoot(array|string $document_root): void
    {
        $this->document_root = $document_root;
    }

    /**
     * @return mixed|string
     */
    public function getRequestUri(): mixed
    {
        return $this->request_uri;
    }

    /**
     * @param mixed|string $request_uri
     */
    public function setRequestUri(mixed $request_uri): void
    {
        $this->request_uri = $request_uri;
    }

    /**
     * @return string|string[]
     */
    public function getFilename(): array|string
    {
        return $this->filename;
    }

    /**
     * @param string|string[] $filename
     */
    public function setFilename(array|string $filename): void
    {
        $this->filename = $filename;
    }
    
    
}