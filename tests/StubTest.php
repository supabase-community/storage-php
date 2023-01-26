<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class StubTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     */

    public function testStub(string $path, string $file_path, array $options): void
    {
        $stub = $this->createStub(\Supabase\Storage\StorageFile::class);
        $stub->method('upload')
             ->willReturn('url');
        $this->assertSame('url', $stub->upload($path, $file_path, $options));
    }

    public function additionProvider(): array
    {
        return [
            ['path/to/file', 'local/path/to/file/', ['public' => true]],
        ];
    }
}