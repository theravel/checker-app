@extends('app')

@section('content')
<div class="container">
	<div class="panel panel-default question-preview">
		<div class="panel-heading">
			Question preview mode
			<a class="pull-right" href="/questions/edit/{{ $question->getId() }}">
				Edit
			</a>
		</div>
		<div class="panel-body">
			@if (Session::has('flash.questionSuggestSuccess'))
				<div class="alert alert-success">
					<p>
						Thank you for contribution!
						Question was successfully created, you can see it below.
					</p>
					<p>
						Please note that every change is reviewed by moderators,
						so it can take some time for publication.
					</p>
				</div>
			@endif
			@if (Session::has('flash.questionEditSuccess'))
				<div class="alert alert-success">
					<p>
						Thank you for contribution!
						New question version was successfully created, you can see it below.
					</p>
					<p>
						Please note that the old version is still available,
						it might be withdrawn by a new version after moderation.
					</p>
				</div>
			@endif
			<div id="markdown-view"
				 data-lang="{{ $question->getProgramLanguage()->getHighlightAlias() }}"
				 data-value="{{{ $question->getTranslation($language) }}}">
			</div>
			<div class="answers-preview">
				@if (1 === $question->getType())
					<input class="form-control answer-input"
						   disabled="disabled"
						   value="Answer..." />
				@elseif (2 === $question->getType())
					<textarea class="form-control answer-input"
							  disabled="disabled">Answer...
					</textarea>
				@else
					<?php $inputType = (3 === $question->getType()) ? 'radio' : 'checkbox'; ?>
					<ul class="answers-list">
					@foreach ($question->getAnswers() as $answer)
						<li class="{{ $inputType }}">
							<label>
								<input type="{{ $inputType }}"
									   disabled="disabled"
									   name="answers"
									   value="{{ $answer->getId() }}"
									   id="answer{{ $answer->getId() }}" />
								{{{ $answer->getTranslation($language) }}}
							</label>
						</li>
					@endforeach
					</ul>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection
