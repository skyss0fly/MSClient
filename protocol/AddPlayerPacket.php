<?php

declare(strict_types=1);


namespace protocol;


use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\utils\UUID;

class AddPlayerPacket extends DataPacket{
	public const NETWORK_ID = ProtocolInfo::ADD_PLAYER_PACKET;

	/** @var UUID */
	public $uuid;
	/** @var string */
	public $username;
	/** @var int|null */
	public $entityUniqueId = null; //TODO
	/** @var int */
	public $entityRuntimeId;
	/** @var Vector3 */
	public $position;
	/** @var Vector3|null */
	public $motion;
	/** @var float */
	public $pitch = 0.0;
	/** @var float|null */
	public $headYaw = null; //TODO
	/** @var float */
	public $yaw = 0.0;
	/** @var Item */
	public $item;
	/** @var array */
	public $metadata = [];

	public function decodePayload() : void{
		$this->uuid = $this->getUUID();
		$this->username = $this->getString();
		$this->entityUniqueId = $this->getEntityUniqueId();
		$this->entityRuntimeId = $this->getEntityRuntimeId();
		$this->position->x = $this->getLFloat();
		$this->position->y = $this->getLFloat();
		$this->position->z = $this->getLFloat();
		$this->motion->x = $this->getLFloat();
		$this->motion->y = $this->getLFloat();
		$this->motion->z = $this->getLFloat();
		$this->pitch = $this->getLFloat();
		$this->headYaw = $this->getLFloat();
		$this->yaw = $this->getLFloat();
		$this->item = $this->getSlot();
		$this->metadata = $this->getEntityMetadata();
	}

	public function encodePayload() : void{
		$this->putUUID($this->uuid);
		$this->putString($this->username);
		$this->putEntityUniqueId($this->entityUniqueId ?? $this->entityRuntimeId);
		$this->putEntityRuntimeId($this->entityRuntimeId);
		$this->putLFloat($this->position->x);
		$this->putLFloat($this->position->y);
		$this->putLFloat($this->position->z);
		$this->putLFloat($this->motion->x);
		$this->putLFloat($this->motion->y);
		$this->putLFloat($this->motion->z);
		$this->putLFloat($this->pitch);
		$this->putLFloat($this->headYaw ?? $this->yaw);
		$this->putLFloat($this->yaw);
		$this->putSlot($this->item);
		$this->putEntityMetadata($this->metadata);
	}
}
