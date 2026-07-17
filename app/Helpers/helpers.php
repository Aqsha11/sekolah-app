<?php

if (!function_exists('clean_html')) {
    /**
     * Sanitize HTML content — strips dangerous tags/attributes, keeps safe formatting.
     */
    function clean_html(?string $html): string
    {
        if (empty($html)) {
            return '';
        }

        $allowed = [
            'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
            'p', 'br', 'hr',
            'strong', 'b', 'em', 'i', 'u', 's',
            'ul', 'ol', 'li',
            'a', 'img',
            'blockquote', 'pre', 'code',
            'table', 'thead', 'tbody', 'tr', 'th', 'td',
            'div', 'span', 'figure', 'figcaption',
        ];

        $html = strip_tags($html, '<' . implode('><', $allowed) . '>');

        // Remove event handler attributes (onclick, onerror, onload, etc.)
        $html = preg_replace('/\s+on\w+\s*=\s*["\'][^"\']*["\']/i', '', $html);
        $html = preg_replace('/\s+on\w+\s*=\s*\S+/i', '', $html);

        // Remove javascript: protocol from href/src
        $html = preg_replace('/(href|src)\s*=\s*["\']?\s*javascript\s*:/i', '$1="#"', $html);

        // Remove data: protocol from src (except common image types)
        $html = preg_replace('/src\s*=\s*["\']?\s*data\s*:(?!image\/(png|jpeg|jpg|gif|webp))/i', 'src="#"', $html);

        return $html;
    }
}
