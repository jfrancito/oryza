<?php

namespace App\Biblioteca;

class Form
{
    /**
     * Generate a HTML <select> element compatible with LaravelCollective Form::select.
     *
     * @param string $name
     * @param array|\Traversable $list
     * @param string|array|null $selected
     * @param array $options
     * @return string
     */
    public static function select($name, $list = [], $selected = null, array $options = [])
    {
        // Format selected as array
        if ($selected instanceof \Illuminate\Support\Collection) {
            $selected = $selected->all();
        } elseif (!is_array($selected)) {
            $selected = $selected !== null && $selected !== '' ? [$selected] : [];
        }

        // Build HTML attributes
        $htmlOptions = [];
        $options['name'] = $name;
        if (!isset($options['id'])) {
            $options['id'] = str_replace(['[', ']'], ['_', ''], $name);
        }

        foreach ($options as $key => $value) {
            if (is_bool($value)) {
                if ($value) {
                    $htmlOptions[] = $key;
                }
            } elseif ($value !== null) {
                $htmlOptions[] = sprintf('%s="%s"', $key, htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
            }
        }

        $attributes = !empty($htmlOptions) ? ' ' . implode(' ', $htmlOptions) : '';

        // Build options list
        $optionsHtml = [];
        if (is_iterable($list)) {
            foreach ($list as $value => $display) {
                if (is_array($display)) {
                    // Optgroup
                    $optgroupHtml = [];
                    foreach ($display as $subValue => $subDisplay) {
                        $isSelected = in_array((string)$subValue, array_map('strval', $selected), true);
                        $optgroupHtml[] = sprintf(
                            '<option value="%s"%s>%s</option>',
                            htmlspecialchars($subValue, ENT_QUOTES, 'UTF-8'),
                            $isSelected ? ' selected="selected"' : '',
                            htmlspecialchars($subDisplay, ENT_QUOTES, 'UTF-8')
                        );
                    }
                    $optionsHtml[] = sprintf(
                        '<optgroup label="%s">%s</optgroup>',
                        htmlspecialchars($value, ENT_QUOTES, 'UTF-8'),
                        implode('', $optgroupHtml)
                    );
                } else {
                    $isSelected = in_array((string)$value, array_map('strval', $selected), true);
                    $optionsHtml[] = sprintf(
                        '<option value="%s"%s>%s</option>',
                        htmlspecialchars($value, ENT_QUOTES, 'UTF-8'),
                        $isSelected ? ' selected="selected"' : '',
                        htmlspecialchars($display, ENT_QUOTES, 'UTF-8')
                    );
                }
            }
        }

        return sprintf('<select%s>%s</select>', $attributes, implode('', $optionsHtml));
    }
}

