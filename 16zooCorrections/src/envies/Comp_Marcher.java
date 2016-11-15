package envies;

import client.ContexteClient;

public class Comp_Marcher implements Comportement {

    public Comp_Marcher() {
    }

    @Override
    public String agir(ContexteClient c) {
        c.getMaPosition().next();
        return "Je marche";
    }

   public String toString() {
        return "Marcher";
    }
}
