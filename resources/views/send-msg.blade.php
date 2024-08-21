@extends('template.main')
@section('content')
    <div class="container-fluid d-flex justify-content-center ">
        <div class="w-50 card">
            <div class="card-body">
                <H4 class="text-center">Message API</H4>

                    <div id="progressBar" class="progress mt-3" style="display: none;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                <form id="smsForm">
                    @csrf
                    <div class="mb-3">
                        <label for="textField" class="form-label">Mask</label>
                        <select name="mask"  class="form-control" >
                            @foreach ($masks as $mask)
                                <option value="{{$mask->mask}}">{{$mask->mask}}</option>    
                            @endforeach
                        </select>
                    </div> 
                     <div class="mb-1">
                        <label for="textField" class="form-label">Subject</label>
                        <input type="text" name="subject" class="form-control" id="textField"
                            placeholder="Enter text here">
                    </div>
                    <div class="mb-1">
                        <label for="textField" class="form-label">Mobile Number(s)</label>
                        <input type="text" name="to" class="form-control" id="textField"
                            placeholder="Enter text here">
                    </div>
                    <div class="mb-1">
                        <label for="textBox" class="form-label">SMS Text</label>
                        <textarea onkeyup="countWords()" name="message" class="form-control" id="textBox" rows="5" placeholder="Enter message here"></textarea>
                        <p class="text-end" ><span id="showChar" >0</span>/500</p>
                    </div>
                    <button class="btn btn-primary">Submit</button>
                </form>
                  <!-- Progress Bar -->
            </div>
        </div>
        
    </div>
  
    <script>
    
    $(document).ready(function() {
        
       
    });

    
        $('#smsForm').on('submit', function(e) {
                e.preventDefault();

                // Show the progress bar
                $('#progressBar').show();

                // Send AJAX POST request
                $.ajax({
                    url: "{{ route('sendSms') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(response) {
                        // Hide the progress bar
                        $('#progressBar').hide();
                        console.log(response);
                         if (response.status === 'success') {
                            toastr.success(response.message);  // Show success toast
                         } else if (response.status === 'error') {
                            toastr.error(response.message);  // Show error toast
                        }
                    },
                    error: function(xhr) {
                        // Hide the progress bar
                        $('#progressBar').hide();
                        alert('Failed to send SMS. Please try again.');
                    }
                });
            
        });
        

        function countWords() {

            // Get the input text value
            let text = document
                .getElementById("textBox").value;
            // Initialize the word counter
            let numWords = 0;
            
            for (let i = 0; i < text.length; i++) {
                let currentCharacter = text[i];
                numWords += 1;
                
            }
            $('#showChar').text(numWords);
         
           
        }
    </script>
@endsection
