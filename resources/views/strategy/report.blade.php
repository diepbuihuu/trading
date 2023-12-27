@extends('layouts.app')
@section('content')

<section class="page-wrapper success-msg">
    <div class="">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    @foreach ($hours as $h)
                    <th> {{ $h }} </th>
                    @endforeach
                    <th>Sum</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $date => $dateData)
                    <tr>
                        <th> {{ $date }} </th>
                        @foreach ($hours as $h)
                            <td>
                                @if (isset($dateData[$h]))
                                    @include('livewire.greendot', ['green' => $dateData[$h][1], 'red' => $dateData[$h][0], 'grey' => $dateData[$h][2]])
                                    <a target="_blank" href="/strategy/{{$strategyID}}/graph/{{$dateData[$h][4]}}">View</a>
                                @endif
                            </td>
                        @endforeach
                        <td>
                                SL: {{ $datesSummary[$date][0] }} <br/>
                                TP: {{ $datesSummary[$date][1] }} <br/>
                                Profit: ${{ $datesSummary[$date][3] }}
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <th>Sum</th>
                    @foreach ($hours as $h)
                        <td>
                                SL: {{ $hoursSummary[$h][0] }} <br/>
                                TP: {{ $hoursSummary[$h][1] }} <br/>
                                Profit: ${{ $hoursSummary[$h][3] }}
                        </td>
                    @endforeach
                    <td>
                        SL: {{ $summary[0] }} <br/>
                        TP: {{ $summary[1] }} <br/>
                        Profit: ${{ $summary[3] }}
                    </td>

                </tr>
            </tbody>
        </table>
    </div>
</section><!-- /.page-warpper -->
@endsection
