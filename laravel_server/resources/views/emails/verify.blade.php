<h1>Welcome to the world of BlackJack!</h1>
<div>
    Thanks for creating an account {{$name}}.
    <br>
    Please follow the link below to verify your email address
    <br><br>
    <a href="{!! url("http://exame.test/api/verify/".$confirmation_code."") !!}" title="Verification Link">Verification Link</a>
    <br><br>
    <br/>
</div>