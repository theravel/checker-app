@extends('app')

@section('content')
<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading">Question preview</div>
		<div class="panel-body">
			<pre id="markdown-view"
				 data-lang="<?= $question->getProgramLanguage()->getHighlightAlias() ?>"
				 data-value="{{ $question->getTranslation($language) }}">
			</pre>
			<?php switch ($question->getType()) {
				case 1: ?>
					<input />
				<?php break; 
				case 2: ?>
					<textarea></textarea>
				<?php break; 
				case 3:
				case 4:
					$inputType = (3 === $question->getType()) ? 'radio' : 'checkbox';
					foreach ($question->getAnswers() as $answer) { ?>
						<div>
							<input type="<?=$inputType?>"
								   name="answers"
								   value="<?=$answer->getId()?>"
								   id="answer<?=$answer->getId()?>" />
							<label for="answer<?=$answer->getId()?>">
								<?= $answer->getTranslation($language) ?>
							</label>
						</div>
					<?php } ?>
				<?php break; ?>
			<?php } ?>
		</div>
	</div>
</div>
@endsection
