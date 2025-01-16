<?php

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;

final class SvgIconsTest extends TestCase
{
    private static $icons_definition = [];
    private static $sprites_crawler = [];

    private const ICONS_DEFINITION_FILE = __DIR__ . '/../dist/icons.json';
    private const SPRITES_FILE = __DIR__ . '/../dist/glpi-illustrations-icons.svg';

    public static function setUpBeforeClass(): void
    {
        self::$icons_definition = json_decode(
            file_get_contents(self::ICONS_DEFINITION_FILE),
            associative: true,
        );

        self::$sprites_crawler = new Crawler(
            file_get_contents(self::SPRITES_FILE),
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

    #[DataProvider('getAllIcons')]
    public function testIconExistInSprites(
        SplFileInfo $file,
    ): void {
        $key = $file->getBasename('.svg');

        $symbol = static::$sprites_crawler->filterXPath(
            sprintf('//symbol[@id="%s"]', $key),
        );
        $this->assertEquals(1, $symbol->count());
    }
}
