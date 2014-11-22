<?php

namespace spec\Changelog;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParserSpec extends ObjectBehavior
{
	function let()
	{
		$this->beConstructedWith(file_get_contents('spec/mocks/changelog.md'));
	}

	function it_is_initializable()
	{
		$this->shouldHaveType('Changelog\Parser');
	}

	function it_can_retrieve_the_description_of_changelog()
	{
		$this->getDescription()->shouldReturn('A general description of your changelog');
	}

	function it_can_retrieve_releases()
	{
		$this->getReleases()->shouldReturn([
			[
				'name' => '0.0.4',
				'date' => '2014-08-09',
				'changes' => [
					'added' => [
						'Addition 1',
						'Addition 2',
					],
					'changed' => [
						'Change 1',
						'Change 2',
					],
					'removed' => [
						'Removal 1',
						'Removal 2',
					]
				]
			],
			[
				'name' => '0.0.3',
				'date' => '2014-08-09',
				'changes' => [
					'added' => [
						'Addition 3',
						'Addition 4',
					],
				]
			],
			[
				'name' => '0.0.2',
				'date' => '2014-07-10',
				'changes' => [
					'changed' => [
						'Change 3',
					],
				]
			],
			[
				'name' => '0.0.1',
				'date' => '2014-05-31',
				'changes' => [
					'removed' => [
						'Removal 3',
					]
				]
			]
		]);
    }

	function it_can_retrieve_a_json_representation_of_a_changelog()
	{
		$this->toJson()->shouldReturn('{"description":"A general description of your changelog","releases":[{"name":"0.0.4","date":"2014-08-09","changes":{"added":["Addition 1","Addition 2"],"changed":["Change 1","Change 2"],"removed":["Removal 1","Removal 2"]}},{"name":"0.0.3","date":"2014-08-09","changes":{"added":["Addition 3","Addition 4"]}},{"name":"0.0.2","date":"2014-07-10","changes":{"changed":["Change 3"]}},{"name":"0.0.1","date":"2014-05-31","changes":{"removed":["Removal 3"]}}]}');
	}
}
