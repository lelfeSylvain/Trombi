package envies;

import client.ContexteClient;

public class Comp_Acheter implements Comportement {

    public Comp_Acheter() {
    }

    @Override
    public String agir(ContexteClient c) {
        return "Je mange une gaufre";
    }
    
   public String toString(){
        return "Acheter";
    }
}
