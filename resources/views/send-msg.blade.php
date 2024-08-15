@extends('template.main')
@section('content')
    <div class="container-fluid d-flex justify-content-center " style="margin-top: 100px;">
        <div class="w-50 card">
            <div class="card-body">
                <H4 class="text-center">Message API</H4>
                <form method="POST" action="{{ route('sendSms') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="textField" class="form-label">Mask</label>
                        <select name="mask"  class="form-control" >
                            @foreach ($masks as $mask)
                                <option value="{{$mask->id}}">{{$mask->mask}}</option>    
                            @endforeach
                        </select>
                        
                    </div> 
                    <div class="mb-3">
                        <label for="textField" class="form-label">Mobile Number(s)</label>
                        <input type="text" name="to" class="form-control" id="textField"
                            placeholder="Enter text here">
                    </div>
                    <div class="mb-3">
                        <label for="textBox" class="form-label">SMS Text</label>
                        <textarea onkeyup="countWords()" name="message" class="form-control" id="textBox" rows="5" placeholder="Enter message here"></textarea>
                        <p class="text-end" ><span id="showChar" >0</span>/500</p>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script>

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
            // Display it as output
           
        }
    </script>
@endsection
