<tr id="row{{ !empty($var) ? $var['id'] : $rand }}">
	<td>
		<input type="hidden" name="id" value="{{ !empty($var) ? $var['id'] : ''  }}">
		<input type="hidden" name="answerId" class="profillingAnswer indexOfSearchId" value="{{ !empty($var) ? $var['answer_id'] : '' }}">
		<input 
		required
		autocomplete="off"
		name="answer"
		type="text" 
		value="{{ !empty($var) ? $var['answer'] : '' }}"
		data-type="profillingAnswer"
		data-target="input[name=answer]-answer|input[name=answerId]-id"
		data-parent="#row{{ !empty($var) ? $var['id'] : $rand }}"
		class="profillingAnswer form-control indexOfSearch">
	</td>
	<td>
		<input type="hidden" name="competenciesId" class="profillingCompetencies indexOfSearchId" value="{{ !empty($var) ? $var['competencies_id'] : '' }}">
		<input 
		required
		autocomplete="off"
		name="competencies"
		type="text" 
		value="{{ !empty($var) ? $var['competencies'] : '' }}"
		data-type="profillingCompetencies"
		data-target="input[name=competencies]-competencies|input[name=competenciesId]-id"
		data-parent="#row{{ !empty($var) ? $var['id'] : $rand }}"
		class="profillingCompetencies form-control indexOfSearch">
	</td>
	<td>
		<span class="btn btn-warning removeDetilsProfilling" data-row="#row{{ !empty($var) ? $var['id'] : $rand }}" title="remove this detil"><i class="fa fa-minus"></i></span>
	</td>
</tr>