@if(session('message'))
  <div class="alert alert-{{session('alert-type')}} alert-dismissible fade show" role="alert" id="aler-message">
      {{session('message')}}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    
    <?php 
    session_start();
    unset($_SESSION['message']); 
    ?>
    @endif

@if (session('resent'))
     <div class="alert alert-success alert-dismissible fade show" role="alert" id="aler-message">
         {{ __('A fresh verification link has been sent to your email address.') }}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
         </button>
      </div>
 @endif

 @if (session('status'))
     <div class="alert alert-success alert-dismissible fade show" role="alert" id="aler-message">
         {{ session('status') }}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
         </button>
      </div>
 @endif