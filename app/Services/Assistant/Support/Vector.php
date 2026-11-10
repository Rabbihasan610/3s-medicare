<?php

namespace App\Services\Assistant\Support;

/*
| MariaDB 10.4 has no vector type, so similarity is computed in PHP over packed
| float32 blobs. Two things keep that cheap enough to do per request:
|
|   - embeddings are requested at 256 dimensions, not 1536 (config/assistant.php)
|   - the L2 norm is stored at index time, so scoring is a bare dot product
|
| Only the FULLTEXT shortlist (~250 rows) is ever unpacked, never the whole table.
*/
class Vector
{
    /** Little-endian float32, 4 bytes per dimension. */
    public static function pack(array $values): string
    {
        return pack('g*', ...$values);
    }

    public static function unpack(?string $blob): array
    {
        if ($blob === null || $blob === '') {
            return [];
        }

        return array_values(unpack('g*', $blob));
    }

    public static function norm(array $values): float
    {
        $sum = 0.0;
        foreach ($values as $v) {
            $sum += $v * $v;
        }

        return sqrt($sum);
    }

    /**
     * Cosine similarity where both norms are already known.
     *
     * Passing the stored norms avoids recomputing a square root per candidate.
     */
    public static function cosine(array $a, array $b, float $normA, float $normB): float
    {
        if ($normA <= 0.0 || $normB <= 0.0) {
            return 0.0;
        }

        $len = min(count($a), count($b));
        if ($len === 0) {
            return 0.0;
        }

        $dot = 0.0;
        for ($i = 0; $i < $len; $i++) {
            $dot += $a[$i] * $b[$i];
        }

        return $dot / ($normA * $normB);
    }
}
