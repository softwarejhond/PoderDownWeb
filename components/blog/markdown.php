<?php

function renderMarkdown(string $text): string
{
    $text = htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

    $blocks = preg_split('/\n\s*\n/', trim($text));
    $html = '';
    $inList = false;
    $inOrderedList = false;
    $inCodeBlock = false;
    $codeContent = '';

    foreach ($blocks as $block) {
        $block = trim($block);

        if ($inCodeBlock) {
            if (preg_match('/^```$/', $block)) {
                $html .= '<pre><code>' . trim($codeContent) . '</code></pre>';
                $inCodeBlock = false;
                $codeContent = '';
            } else {
                $codeContent .= ($codeContent ? "\n" : '') . $block;
            }
            continue;
        }

        if (preg_match('/^```/', $block)) {
            $inCodeBlock = true;
            $codeContent = preg_replace('/^```\w*\n?/', '', $block);
            continue;
        }

        if (preg_match('/^(#{1,6})\s+(.+)$/', $block, $m)) {
            if ($inList) { $html .= "</ul>\n"; $inList = false; }
            if ($inOrderedList) { $html .= "</ol>\n"; $inOrderedList = false; }
            $level = strlen($m[1]);
            $html .= "<h{$level}>" . parseInline($m[2]) . "</h{$level}>";
            continue;
        }

        if (preg_match('/^\-{3,}$/', $block)) {
            if ($inList) { $html .= "</ul>\n"; $inList = false; }
            if ($inOrderedList) { $html .= "</ol>\n"; $inOrderedList = false; }
            $html .= "<hr>";
            continue;
        }

        $lines = explode("\n", $block);
        $allUl = true;
        $allOl = true;
        foreach ($lines as $line) {
            if (!preg_match('/^[\-\*]\s/', $line)) { $allUl = false; }
            if (!preg_match('/^\d+\.\s/', $line)) { $allOl = false; }
        }

        if ($allUl) {
            if ($inOrderedList) { $html .= "</ol>\n"; $inOrderedList = false; }
            if (!$inList) { $html .= "<ul>\n"; $inList = true; }
            foreach ($lines as $line) {
                $content = preg_replace('/^[\-\*]\s+/', '', $line);
                $html .= "<li>" . parseInline($content) . "</li>\n";
            }
            continue;
        }

        if ($allOl) {
            if ($inList) { $html .= "</ul>\n"; $inList = false; }
            if (!$inOrderedList) { $html .= "<ol>\n"; $inOrderedList = true; }
            foreach ($lines as $line) {
                $content = preg_replace('/^\d+\.\s+/', '', $line);
                $html .= "<li>" . parseInline($content) . "</li>\n";
            }
            continue;
        }

        if ($inList) { $html .= "</ul>\n"; $inList = false; }
        if ($inOrderedList) { $html .= "</ol>\n"; $inOrderedList = false; }

        $html .= "<p>" . parseInline($block) . "</p>";
    }

    if ($inCodeBlock) {
        $html .= '<pre><code>' . trim($codeContent) . '</code></pre>';
    }
    if ($inList) { $html .= "</ul>\n"; }
    if ($inOrderedList) { $html .= "</ol>\n"; }

    return $html;
}

function parseInline(string $text): string
{
    $text = preg_replace('/!\[([^\]]*)\]\(([^\)]+)\)/', '<img src="$2" alt="$1" class="img-fluid rounded my-3">', $text);
    $text = preg_replace('/\[([^\]]+)\]\(([^\)]+)\)/', '<a href="$2" target="_blank" rel="noopener noreferrer">$1</a>', $text);
    $text = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $text);
    $text = preg_replace('/\*(.+?)\*/', '<em>$1</em>', $text);
    $text = preg_replace('/`([^`]+)`/', '<code class="bg-light px-1 rounded">$1</code>', $text);
    return $text;
}
