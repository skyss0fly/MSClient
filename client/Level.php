<?php

namespace client;

use pocketmine\level\format\Chunk;

class Level
{
	/** @var array */
	private $chunks = [];

	/**
	 * @return array
	 */
	function getChunks(): array
	{
		return $this->chunks;
	}

	/**
	 * @param int $chunkX
	 * @param int $chunkZ
	 * @return bool
	 */
	function isChunk(int $chunkX, int $chunkZ)
	{
		return isset($this->chunks[$chunkX], $this->chunks[$chunkX][$chunkZ]);
	}

	/**
	 * @param int $chunkX
	 * @param int $chunkZ
	 * @return Chunk|null
	 */
	function getChunk(int $chunkX, int $chunkZ): ?Chunk
	{
		return $this->isChunk($chunkX, $chunkZ) ? $this->chunks[$chunkX][$chunkZ] : null;
	}

	/**
	 * @param Chunk $chunk
	 * @return bool
	 */
	function addChunk(Chunk $chunk): bool
	{
		$chunkX = $chunk->getX();
		$chunkZ = $chunk->getZ();
		if ($this->isChunk($chunkX, $chunkZ)) return false;
		if (!isset($this->chunks[$chunkX])) $this->chunks[$chunkX] = [];
		$this->chunks[$chunkX][$chunkZ] = $chunk;
		return true;
	}

	/**
	 * @param float $x
	 * @param float $y
	 * @param float $z
	 * @return int
	 */
	function getBlockIdAt(float $x, float $y, float $z): int
	{
		if ($this->isChunk($chunkX = $x >> 4, $chunkZ = $z >> 4)) {
			$chunk = $this->getChunk($chunkX, $chunkZ);
			return $chunk->getBlockId($x, $y, $z);
		}
		return 0;
	}

	/**
	 * @param float $x
	 * @param float $y
	 * @param float $z
	 * @return int
	 */
	function getBlockDataAt(float $x, float $y, float $z): int
	{
		if ($this->isChunk($chunkX = $x >> 4, $chunkZ = $z >> 4)) {
			$chunk = $this->getChunk($chunkX, $chunkZ);
			return $chunk->getBlockData($x, $y, $z);
		}
		return 0;
	}

	/**
	 * @param float $x
	 * @param float $z
	 * @return int
	 */
	function getHighestBlockAt(float $x, float $z): int
	{
		if ($this->isChunk($chunkX = $x >> 4, $chunkZ = $z >> 4)) {
			$chunk = $this->getChunk($chunkX, $chunkZ);
			return $chunk->getHighestBlockAt($x, $z);
		}
		return 0;
	}
}