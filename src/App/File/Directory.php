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
                $content = file_get_contents($file->getRealPath());
                $tokens = token_get_all($content);
                $namespace = '';
                for ($index = 0; isset($tokens[$index]); $index++) {
                    if (!isset($tokens[$index][0])) {
                        continue;
                    }
                    if (T_NAMESPACE == $tokens[$index][0]) {
                        $index += 2; // Skip namespace keyword and whitespace
                        while (isset($tokens[$index]) && is_array($tokens[$index])) {
                            $namespace .= $tokens[$index++][1];
                        }
                    }
                    if (T_CLASS == $tokens[$index][0] && T_WHITESPACE == $tokens[$index + 1][0] && T_STRING == $tokens[$index + 2][0]) {
                        $index += 2; // Skip class keyword and whitespace
                        $classes[] = $namespace.'\\'.$tokens[$index][1];
                        # break if you have one class per file (psr-4 compliant)
                        # otherwise you'll need to handle class constants (Foo::class)
                        break;
                    }
                }
            }
        }
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