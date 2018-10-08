
<form method="post" action="index.php?uc=login&num=in" name='identification' class="form-horizontal col-md-12 col-xs-12 jumbotron ">
    <fieldset>
        <div class="form-group">
            <label class="col-md-4 control-label" for="login">Pour se connecter :</label>  
            <div class="col-md-4">
                <input id="textinput" name="login" placeholder="votre identifiant" class="form-control input-md" type="text">
                
            </div>
        </div>

        <!-- Password input-->
        <div class="form-group">
            <label class="col-md-4 control-label" for="password">Mot de passe :</label>
            <div class="col-md-4">
                <input id="passwordinput" name="password" placeholder="votre mot de passe" class="form-control input-md" type="password">
                
            </div>
        </div>

        <!-- Button -->
        <div class="form-group">
            <div class="col-md-4">
                <button id="singlebutton" name="singlebutton" class="btn btn-primary" onClick="doChallengeResponse();">Connexion</button>
            </div>
        </div>      
        <input type="hidden" name="reponse"  value="" size=32>
    </fieldset>
</form>

