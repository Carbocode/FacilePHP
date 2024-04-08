<?php

namespace FacilePHP\PDF;

/**
 * The Text class defines the properties and methods for a text element that can be added to a PDF.
 * It stores the text's content, position, size, font family, and style.
 */
final class Text
{
    /** The text content */
    public string $text;
    /** The x-coordinate position of the text */
    public int $x;
    /** The y-coordinate position of the text */
    public int $y;
    /** The font size of the text */
    public int $size;
    /** The font family of the text */
    public string $family;
    /** The font family of the text */
    public string $style;

    /**
     * Constructs a new Text object with specified properties.
     *
     * @param string $text The text content.
     * @param int $x The x-coordinate position (default 0).
     * @param int $y The y-coordinate position (default 0).
     * @param int $size The font size (default 12).
     * @param string $family The font family (default 'Helvetica').
     * @param string $style The font style (default '').
     */
    public function __construct($text, $x = 0, $y = 0, $size = 12, $family = 'Helvetica', $style = '')
    {
        $this->text   = $text;
        $this->x      = $x;
        $this->y      = $y;
        $this->size   = $size;
        $this->family = $family;
        $this->style  = $style;
    }

    /**
     * Gets the text content.
     *
     * @return string The text content.
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Gets the x-coordinate position.
     *
     * @return int The x-coordinate position.
     */
    public function getX(): int
    {
        return $this->x;
    }

    /**
     * Gets the y-coordinate position.
     *
     * @return int The y-coordinate position.
     */
    public function getY(): int
    {
        return $this->y;
    }

    /**
     * Gets the font size.
     *
     * @return int The font size.
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Gets the font family.
     *
     * @return string The font family.
     */
    public function getFamily(): string
    {
        return $this->family;
    }

    /**
     * Gets the font style.
     *
     * @return string The font style.
     */
    public function getStyle(): string
    {
        return $this->style;
    }
}
