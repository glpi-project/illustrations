<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class IconsDefinitionTest extends TestCase
{
    private static $icons_definition = [];

    private const ICONS_DEFINITION_FILE = __DIR__ . '/../dist/icons.json';

    public static function setUpBeforeClass(): void
    {
        self::$icons_definition = json_decode(
            file_get_contents(self::ICONS_DEFINITION_FILE),
            associative: true,
        );
    }

    public static function getAllIcons(): iterable
    {
        $iterator = new DirectoryIterator(__DIR__ . "/../svg/icons");
        foreach ($iterator as $file) {
            /** @var \SplFileInfo $file */
            if ($file->isDir() || $file->getExtension() !== 'svg') {
                continue;
            }

            yield [$file->getFileInfo()];
        }
    }

    public function testThatIconFileExist(): void
    {
        $this->assertFileExists(self::ICONS_DEFINITION_FILE);
    }

    #[DataProvider('getAllIcons')]
    public function testIconIsRegisteredInDefinitionFile(
        SplFileInfo $file,
    ): void {
        $key = $file->getBasename('.svg');

        // Validate that the icon is defined.
        $this->assertArrayHasKey($key, static::$icons_definition);
        $this->assertArrayHasKey('title', static::$icons_definition[$key]);
        $this->assertArrayHasKey('tags', static::$icons_definition[$key]);

        // Validate icon title.
        $this->assertNotEmpty(static::$icons_definition[$key]['title']);
    }

    #[DataProvider('getAllIcons')]
    public function testIconUseSpecificColors(
        SplFileInfo $file,
    ): void {
        $allowed_colors = ['white', '#2F3F64', '#FEC95C', '#BCC5DC', 'none'];
        $mandatory_colors = ['#2F3F64', '#BCC5DC'];

        $svg_content = file_get_contents($file->getPath() . '/' . $file->getFilename());
        preg_match_all('/fill="(.*?)"/', $svg_content, $matches);
        $colors = $matches[1];

        $unexpected_colors = array_diff($colors, $allowed_colors);
        $this->assertEmpty($unexpected_colors, sprintf(
            "Unexpected color(s) for %s: %s.",
            $file->getFileName(),
            implode(", ", $unexpected_colors)
        ));

        $missing_colors = array_diff($mandatory_colors, $colors);
        $this->assertEmpty($missing_colors, sprintf(
            "Missing mandatory color(s) for %s: %s.",
            $file->getFileName(),
            implode(", ", $missing_colors)
        ));
    }
}
