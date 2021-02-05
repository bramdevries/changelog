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

	function it_can_retrieve_multi_line_description()
	{
		$this->beConstructedWith(file_get_contents('spec/mocks/multi_line_description.md'));

		$this->getDescription()->shouldReturn('A general description of your changelog

on multiple lines');
	}

	function it_can_retrieve_no_description_if_not_available()
	{
		$this->beConstructedWith(file_get_contents('spec/mocks/no_description.md'));

		$this->getDescription()->shouldReturn(null);
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

	function it_can_retrieve_unreleased_changes()
	{
		$this->beConstructedWith(file_get_contents('spec/mocks/unreleased.md'));

		$this->getReleases()->shouldReturn([
				[
						'name' => 'Unreleased',
						'date' => null,
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

	function it_can_retrieve_a_single_list_of_changes()
	{
		$this->beConstructedWith(file_get_contents('spec/mocks/pull_request.md'));

		$this->getChanges()->shouldReturn([
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
		]);
	}

	function it_can_retrieve_special_cases()
	{
		$this->beConstructedWith(file_get_contents('spec/mocks/special_cases.md'));
		$this->getChanges()->shouldReturn([
			'added' => [
				'string_with_underscores'
			]
		]);
	}

	function it_can_retrieve_html_code()
	{
		$this->beConstructedWith(file_get_contents('spec/mocks/html_code.md'));
		$this->getChanges()->shouldReturn([
			'added' => [
				'Addition one',
				'<code>Piece of code</code> Addition two'
			]
		]);
	}

	function it_can_fails_on_empty_headers()
	{
		$this->beConstructedWith(file_get_contents('spec/mocks/header_with_forgotten_text.md'));
		$this->getChanges()->shouldReturn([]);
	}

	function it_can_handle_nested_bullet_points()
	{
		$this->beConstructedWith(file_get_contents('spec/mocks/with_nested_bullets.md'));

		$this->getChanges()->shouldReturn([
			'changed' => [
				'I have nested bullet points<ul><li>nested bullet point 1</li><li>nested bullet point 2</li></ul>'
			]
		]);
	}
}
