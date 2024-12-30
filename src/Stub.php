<?php

namespace Jonathanrixhon\Contents;

use Illuminate\Support\Facades\File;

class Stub
{
    /*
    * The stub file's path
    */
    public string $from;

    /*
    * The path where the stub is gonna be published
    */
    public string $to;

    /*
    * The stubs file content
    */
    public string $content;

    /*
    * The placeholders and the corresponding values
    */
    public array $placeholders = [];

    public function __construct(string $from, string $to)
    {
        $this->from = $from;
        $this->to = $to;
        $this->content = file_get_contents($this->from);
    }

    public static function make(string $from, string $to): Stub
    {
        return new Stub($from, $to);
    }

    public function publish(): void
    {
        if (!count($this->placeholders)) throw new \Exception("No placehoders has been encoded", 1);

        $content = $this->replacePlaceholders();

        File::ensureDirectoryExists(pathinfo($this->to, PATHINFO_DIRNAME));
        File::put($this->to, $content);
    }

    public function placeholders(array $placeholders): Stub
    {
        $this->placeholders = $placeholders;
        return $this;
    }

    protected function replacePlaceholders(array|null $placeholders = null): string
    {
        $placeholders = $placeholders ?: $this->placeholders;
        $result = $this->content;

        foreach ($placeholders as $placeholder => $value) {
            $result = str_replace('{%' . $placeholder . '%}', $value, $result);
        }

        return $result;
    }
}
