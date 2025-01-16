       <div class="page-content" hidden>
           <div class="container-fluid">


               <div id="printrecipt-id" style="margin-top: 80px; margin-left: 40px;">
                   {{-- date and OR number --}}
                   @if (array_key_exists('or_number', $studentData) && array_key_exists('created_at', $studentData))
                       <p
                           style="position: fixed; right: 200px; bottom: 290; font-family: Courier New, Courier, monospace; font-size: 12px;">
                           {{ $studentData['or_number'] }} <br> {{ $studentData['created_at'] }}
                       </p>
                   @endif
                   {{-- name --}}

                   @if (isset($studentData['scholarship']) && $studentData['scholarship'] === 'true')
                       <p
                           style="letter-spacing: 1px; margin-top: -80px; margin-left:60px; font-family: Courier New, Courier, monospace; font-size: 12px;">
                           <span></span> {{ $studentData['particulars'] }}
                       </p>
                   @elseif (isset($studentData['first_name']))
                       <p
                           style="letter-spacing: 1px; margin-top: -40px; margin-left:40px; font-family: Courier New, Courier, monospace; font-size: 12px;">
                           {{ $studentData['first_name'] }} <span></span> {{ $studentData['last_name'] }}
                       </p>
                   @else
                       <p>Student data unavailable</p>
                   @endif

                   {{-- Address --}}
                   @if (isset($studentData['home_address']))
                       <p
                           style="letter-spacing: 1px; margin-top: -11px; margin-left:10px; font-family:Courier New, Courier, monospace; font-size: 12px;">
                           {{ $studentData['home_address'] }}</p>
                   @endif
                   {{-- Sum in numbers --}}
                   @if (isset($studentData['downpayment2']))
                       <p
                           style="letter-spacing: 1px; margin-top: 38px; margin-left:40px; font-family: Courier New, Courier, monospace; font-size: 12px;">
                           {{ $capitalizedWords }} pesos
                       </p>
                   @endif
                   <div
                       style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px; font-family: Courier New, Courier, monospace; font-size: 12px;">

                       @if ($studentData['PaymenentStatus'] === 'FULL PAYMENT')
                           <div
                               style="letter-spacing: 1px; margin-top: 38px; margin-left:40px; font-family: Courier New, Courier, monospace; font-size: 12px;">
                               FULL PAYMENT
                           </div>
                       @else
                           @php
                               $fees = $studentData['fees'];
                               $numFees = count($fees);
                               $chunkSize = 5;
                               $numChunks = ceil($numFees / $chunkSize);
                           @endphp

                           @for ($chunk = 0; $chunk < min(3, $numChunks); $chunk++)
                               <table style="width: 30%; border-spacing: 0;">
                                   <thead>
                                       <tr></tr>
                                   </thead>
                                   <tbody style="display: block; max-height: 300px; overflow-y: auto;">
                                       @for ($i = $chunk * $chunkSize; $i < min(($chunk + 1) * $chunkSize, $numFees); $i++)
                                           <tr>
                                               <td style="text-align: left; padding-right: 15px;">
                                                   {{ $fees[$i]['subCategory'] }}
                                               </td>
                                               <td style="text-align: right; padding-right: 15px;">
                                                   {{ number_format($fees[$i]['amount_subtracted'], 2, '.', ',') }}
                                               </td>
                                           </tr>
                                       @endfor

                                       @if ($chunk == 2 && $numFees > 15)
                                           <tr>
                                               <td colspan="2" style="text-align: center;">and more...</td>
                                           </tr>
                                       @endif
                                   </tbody>
                               </table>
                           @endfor
                       @endif

                   </div>



                   {{-- <table style="width:50%; border-spacing: 0;">
                           <tr>
                               <td style="text-align:left;">Amount Received:</td>
                               <td style="text-align:right; padding-right: 10px;">
                                   {{ number_format($studentData['downpayment2'], 2, '.', ',') }}
                               </td>
                           </tr>
                           <tr>
                               <td style="text-align:left;">Amount Paid:</td>
                               <td style="text-align:right; padding-right: 10px;">
                                   {{ number_format($studentData['downpayment'], 2, '.', ',') }}
                               </td>
                           </tr>
                           <tr>
                               <td style="text-align:left;">Change Due:</td>
                               <td style="text-align:right; padding-right: 10px;">
                                   {{ number_format($studentData['excess'], 2, '.', ',') }}
                               </td>
                           </tr>
                       </table> --}}
                   {{-- <tr>
                       <td style="text-align:left;">Change Due:</td>
                       <td style="text-align:right; padding-right: 10px;">
                           {{ number_format($studentData['excess'], 2, '.', ',') }}
                       </td>
                   </tr> --}}


                   <div
                       style="position: relative; width: 100%; height: 100%; margin-top:50px; font-family: Courier New, Courier, monospace;">
                       <div style="position:fixed; bottom:0; width: 68%; margin-left: 110px; font-size: 12px; ">
                           <p style="position:fixed; bottom:80px;">{{ $studentData['downpayment'] }}</p>
                           <p style="position:fixed; bottom:20px;">{{ $studentData['downpayment'] }}</p>
                       </div>

                       {{-- <div
                           style="position: fixed; bottom:0; width: 68%; margin-left: 110px; margin-top: 40px; font-size: 12px;">
                           <p>{{ $studentData['downpayment'] }}</p>
                       </div> --}}

                       {{-- Fixed Cashier --}}
                       <div style="position: absolute; bottom: 40px; left: 280px; font-size: 14px;">
                           <p style="position:fixed; bottom:3px; left:480px">{{ Auth::user()->name }}</p>
                       </div>
                   </div>


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
