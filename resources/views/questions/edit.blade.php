@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default question-suggest">
				<div class="panel-heading">Suggest a question</div>

				<form class="panel-body" mathod="POST" id="question-suggest">

				<div class="errors-wrapper" id="validation-errors">
					<div class="alert alert-danger hidden" id="error-empty-text">
						Question text cannot be empty
					</div>
					<div class="alert alert-danger hidden" id="error-no-answers">
						There should be at least two answers
					</div>
					<div class="alert alert-danger hidden" id="error-empty-answer">
						Answers cannot be empty
					</div>
					<div class="alert alert-danger hidden" id="error-no-correct">
						At least one answer must be flagged as correct
					</div>
					<div class="alert alert-danger hidden" id="error-server">
						Cannot save question due to internal error
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="usr">Answer type</label>
							<select class="form-control" id="question-type" name="questionType">
								@foreach ($questionTypes as $id => $text)
									<option value="{{ $id }}"
											{{ ($id === $activeQuestionType) ? 'selected="selected"' : '' }}>
										{{ $text }}
									</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="form-group">
							<label for="usr">Programming language</label>
							<select class="form-control" id="question-program-lang" name="programLanguage">
								@foreach ($programLanguages as $programLanguage)
									<option value="{{ $programLanguage->getId() }}"
											data-highlight="{{ $programLanguage->getHighlightAlias() }}"
											{{ ($programLanguage->getId() == $activeProgramLanguageId) ? 'selected="selected"' : '' }}>
										{{ $programLanguage->getName() }}
									</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>

				<div class="form-group question-categories">
					<label>Categories (multiple values can be separated by comma)</label>
					<span class="hidden" id="t-categories-placeholder">E.g. OOP, Algorithms, Patterns</span>
					<ul id="question-categories" name="categories">
						@foreach ($categories as $category)
							<li>{{ $category->getName() }}</li>
						@endforeach
					</ul>
				</div>

				<div class="panel panel-default editor-panel" id="editor-area">
					<div class="panel-heading">
						<span class="question-text">Question text</span>
						<div class="btn-toolbar pull-right" role="toolbar">
							<div class="btn-group" role="group">
								<button id="editor-preview-btn"
										title="Preview mode"
										type="button"
									class="btn btn-default glyphicon glyphicon-eye-open">
								</button>
								<button id="editor-edit-btn"
										title="Edit mode"
										type="button"
									class="btn btn-default glyphicon glyphicon-edit hidden">
								</button>
								<a id="editor-help-btn" href="https://guides.github.com/features/mastering-markdown/" target="_blank" title="Syntax help" class="btn btn-default glyphicon glyphicon-question-sign"></a>
							</div>
							<div class="btn-group" role="group">
								<button id="enable-fullscreen-btn"
										title="Fullscreen mode"
										type="button"
									class="btn btn-default glyphicon glyphicon-fullscreen">
								</button>
							</div>
							<div class="btn-group" role="group">
								<button id="exit-fullscreen-btn"
										title="Exit fullscreen"
										type="button"
									class="btn btn-default glyphicon glyphicon-resize-small hidden">
								</button>
							</div>
						</div>
						<div class="clear"></div>
					</div>
					<div class="panel-body">
						<div id="editor-input">
<textarea id="code" name="text">@if ($question) {{ $question->getTranslation($language) }} @else @include('questions/sample/text') @endif</textarea>
								<div class="editor-hints">
									Use <a href="https://guides.github.com/features/mastering-markdown/">Markdown</a> 
									syntax and indent source code for highlighting
								</div>
						</div>
						<div id="markdown-view" class="hidden">
						</div>
					</div>
				</div>

				<div id="question-answers-block"
					 data-save-url="/questions/{{ $question ? 'edit/' . $question->getId() : 'suggest' }}"
					 class="panel panel-default {{ in_array($activeQuestionType, $typesWithoutAnswers) ? 'hidden' : '' }}">
					<div class="panel-heading">
						<span>Answers</span>
					</div>
					<div class="panel-body answers-container">
						<button class="btn btn-default add-answer"
								type="button">
							Add new answer
						</button>
						<div class="flag-correct-hint pull-right">
							Flag correct answers with
							<span class="glyphicon glyphicon-ok-circle answer-correct-ok"></span>
						</div>
						<div class="clear"></div>
						@foreach ([3 => 'radio', 4 => 'checkbox'] as $typeId => $inputType)
							<div id="active-answers-{{ $typeId }}"
								 class="active-answers-area {{ ($activeQuestionType === $typeId) ?: 'hidden' }}">
								@include('questions/partial/answer', [
									'isTemplate' => true,
									'inputType' => $inputType,
									'typeId' => $typeId,
									'answer' => null,
								])
								@foreach ($answers[$typeId] as $answer)
									@include('questions/partial/answer', [
										'isTemplate' => false,
										'inputType' => $inputType,
										'typeId' => $typeId,
										'answer' => $answer,
										'language' => $language,
									])
								@endforeach
							</div>
						@endforeach
					</div>
				</div>

				<button type="submit" class="btn btn-primary pull-right btn-spinner">
					<i class="glyphicon glyphicon-refresh glyphicon-spin"></i>
					Submit new question
				</button>
			</form>
		</div>
	</div>
</div>
@endsection
