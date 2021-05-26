<?php

declare(strict_types=1);

namespace App\Model;

use Nette;


/**
 * Feedbacks.
 */
final class Feedbacks
{
	use Nette\SmartObject;

	private const
		TABLE_NAME = 'feedbacks',
		COLUMN_FEED_ID = 'feed_id',
		COLUMN_FEED_EMAIL = 'feed_email',
		COLUMN_FEED_TEXT = 'feed_text';

	/** @var Nette\Database\Context */
	private $db;

	public function __construct(Nette\Database\Context $db)
	{
		$this->db = $db;
	}
        
        public function insert($feed_email, $feed_text)
        {
            $this->db->table(self::TABLE_NAME)->insert([
                self::COLUMN_FEED_EMAIL => $feed_email,
                self::COLUMN_FEED_TEXT => $feed_text
            ]);
        }
}
