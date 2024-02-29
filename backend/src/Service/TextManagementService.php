<?php

namespace App\Service;

class TextManagementService
{

    public function handleTags(string $text): array
    {
        $tags_description = [];
        $tags_text = [];

        $pattern = '~\[(?<tag>\w+)(\s?description=(?<quotes>\W)(?<description>[^"]+)\k<quotes>)?\](?<text>[^[]*)\[\/\1\]~iuU';
        if (preg_match_all($pattern, $text, $matches, PREG_PATTERN_ORDER)) {
            foreach ($matches[1] as $key => $value) {
                $tags_description[$value] = $matches["description"][$key];
                if (isset($matches[3][$key])) {
                    $tags_text[$value] = $matches["text"][$key];
                }
            }
        }

        return [
            'tags_description' => $tags_description,
            'tags_text' => $tags_text
        ];
    }

    public function handleKeys(string $text): array
    {
        $matches = [];
        preg_match_all('/\b(?:one|two|three): (.*?)(?=\b(?:one|two|three): |$)/s', $text, $matches);

        $result = [];
        foreach ($matches[0] as $key => $value) {
            preg_match('/\b(?:one|two|three)\b/', $value, $keyMatches);
            $keyName = $keyMatches[0];
            $result[$keyName] = trim($matches[1][$key]);
        }

        return $result;
    }
}
