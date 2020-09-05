<table border="1" cellpadding="5" cellspacing="5">
    <tr>
        <th>Name</th>
        <th colspan="8">{{ $Transaction->name }}</th>
    </tr>
    <tr>
        <th>Email</th>
        <th colspan="8">{{ $Transaction->email }}</th>
    </tr>
    <tr>
        <th>Phone</th>
        <th colspan="8">{{ $Transaction->phone }}</th>
    </tr>

    @foreach($Transaction->result as $key => $row)
    <tr>
    	<td colspan="9" style="text-align:center;">
    		{{ $row->criteria->criteria }}
    	</td>
    </tr>
    @php $echoCompentecies = true; @endphp
	@foreach(App\Http\Controllers\DashboardController::getQuestion($Transaction->id,$row->criteria->id) as $prof)
    @if($echoCompentecies == true)
    @php $echoCompentecies = false; @endphp
    <tr>
        <td>Question</td>
        @php $Compentecies = App\Http\Controllers\DashboardController::getCompetencies($row->criteria->id,$prof->question); @endphp
        @foreach($Compentecies as $cptcs)
        <td colspan="2">{{ $cptcs->getCompetencies->competencies }}</td>
        @endforeach
    </tr>
    @endif
    <tr>
    	<td>{{ $prof->getQuestion->question }}</td>
        @php $answerOld = []; @endphp
        @foreach($Compentecies as $cptcs)
    	@foreach(App\Http\Controllers\DashboardController::getAnswer($row->criteria->id,$prof->question,$cptcs->competencies,$answerOld) as $answ)
        @php $answerOld[] = $answ->id; @endphp
    	<td style="text-align:center;">{{ $answ->getAnswerReport($answ->id,$answ->answer,$Transaction->id) }}</td>
    	<td>{{ $answ->getAnswer->answer }}</td>
    	@endforeach
        @endforeach
    </tr>
	@endforeach 
    
    @php 
        $toArr = (array)$row; 
    @endphp
    <tr>
        <td>Resault</td>
        @foreach($Compentecies as $cptcs)
        <td>
            count
        </td>
        <td>
            percen
        </td>
        @endforeach
    </tr>
    <?php
    /*
    <tr>
        <td>Real</td>
        @foreach($Compentecies as $cptcs)
        @php 
            $collection = (new Illuminate\Support\Collection($toArr['resault']))->firstWhere('competencies_id', $cptcs->competencies);
        @endphp
        <td style="text-align:right;">
            {{ $collection->real_resault }}
        </td>
        <td style="text-align:right;">
            {{ $collection->real_percen }}%
        </td>
        @endforeach
    </tr>
    */
    ?>
    <tr>
        <?php // <td>Revision</td> ?>
        <td></td>
        @foreach($Compentecies as $cptcs)
        @php 
            $collection = (new Illuminate\Support\Collection($toArr['resault']))->firstWhere('competencies_id', $cptcs->competencies);
        @endphp
        <td style="text-align:right;">
            {{ $collection->revision_resault }}
        </td>
        <td style="text-align:right;">
            {{ $collection->revision_percen }}%
        </td>
        @endforeach
    </tr>
    
    @endforeach
</table>