<div class="input-group answer-wrapper {{ $isTemplate ? 'answer-template' : '' }}">
	<span class="input-group-addon answer-correct-toggle
		  {{ ($answer && $answer->getIsCorrect()) ? 'answer-correct-ok' : 'answer-correct-wrong' }}">
		<label class="glyphicon glyphicon-remove-circle"></label>
		<input type="{{ $inputType }}" class="correct-switch" />
		<input type="hidden"
			   class="correct-switch-value"
				@if ($isTemplate)
					data-name="answersCorrect[{{ $typeId }}][]"
				@else
					name="answersCorrect[{{ $typeId }}][]"
				@endif
			   value="{{ $answer ? $answer->getIsCorrect() : 0 }}"
			   />
	</span>
	<input type="text" class="form-control answer-text"
		   value="{{ $answer ? $answer->getTranslation($language) : '' }}"
			@if ($isTemplate)
				data-name="answers[{{ $typeId }}][]"
			@else
				name="answers[{{ $typeId }}][]"
			@endif
		   />
	<span class="input-group-btn">
		<button class="btn btn-default answer-remove" type="button">
			Remove
		</button>
	</span>
</div>