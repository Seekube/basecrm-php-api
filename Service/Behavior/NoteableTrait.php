<?php

namespace prgTW\BaseCRM\Service\Behavior;

use prgTW\BaseCRM\Service\Detached\Note;
use prgTW\BaseCRM\Service\Notes;

/**
 * @method Notes getNotes()
 */
trait NoteableTrait
{
	/**
	 * @param string $content
	 *
	 * @return Resource
	 */
	public function addNote($content)
	{
		$note = new Note();
		$note->content = $content;

		/** @var Notes $notes */
		$notes  = $this->getNotes();
		$result = $notes->create($note, [
			'content',
		]);

		return $result;
	}
}
