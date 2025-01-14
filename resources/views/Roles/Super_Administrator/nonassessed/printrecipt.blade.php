       <div class="page-content" hidden>
           <div class="container-fluid">


               <div id="printrecipt-id" style="margin-top: 80px; margin-left: 40px;">
                   {{-- date and OR number --}}
                   @if (array_key_exists('or_number', $studentData) && array_key_exists('created_at', $studentData))
                       <p
                           style="position: absolute; right: 400px; top: 30px; font-family:'Courier New', Courier, monospace; font-size: 10px;">
                           {{ $studentData['or_number'] }} <br> {{ $studentData['created_at'] }}
                       </p>
                   @endif
                   {{-- name --}}

                   @if (isset($studentData['first_name']))
                       <p
                           style="letter-spacing: 1px; margin-top: -20px; margin-left:10px; font-family:'Courier New', Courier, monospace; font-size: 12px;">
                           {{ $studentData['first_name'] }} <span></span> {{ $studentData['last_name'] }}
                       </p>
                   @else
                       <p>Student data unavailable</p>
                   @endif
                   {{-- Address --}}
                   @if (isset($studentData['home_address']))
                       <p
                           style="letter-spacing: 1px; margin-top: -11px; margin-left:10px; font-family:'Courier New', Courier, monospace; font-size: 12px;">
                           {{ $studentData['home_address'] }}</p>
                   @endif
                   {{-- Sum in numbers --}}
                   @if (isset($studentData['amount']))
                       <p
                           style="letter-spacing: 1px; margin-top: 30px; margin-left:10px; font-family:'Courier New', Courier, monospace; font-size: 12px;">
                           {{ $capitalizedWords }} pesos
                       </p>
                   @endif
                   {{-- description --}}
                   <table
                       style="margin-top: 20px; width:68%; margin-left:-10px; margin-right:-10px; font-family:'Courier New', Courier, monospace; font-size: 12px;">

                       <tr>
                           <td style="text-align:left;">{{ $studentData['particulars'] }}</td>
                           <td>{{ $studentData['amount'] }}</td>
                       </tr>
                   </table>
                   <div
                       style="margin-top: 44px; width:68%; margin-left:80px; font-family:'Courier New', Courier, monospace; font-size: 12px;">
                       <p>{{ $studentData['amount'] }}</p>
                   </div>

                   <div
                       style="margin-top: 40px; width:68%; margin-left:80px; font-family:'Courier New', Courier, monospace; font-size: 12px;">
                       <p>{{ $studentData['amount'] }}</p>
                   </div>
                   {{-- Cashier --}}
                   <p
                       style="position: absolute; left:240px; top: 310px;  font-family:'Courier New', Courier, monospace; font-size: 14px;">
                       {{ Auth::user()->name }}</p>
               </div>
           </div>
       </div>
       </div>
       </div>

       @push('scripts')
           <script>
               //throw an ajax to  backnd
           </script>
       @endpush
