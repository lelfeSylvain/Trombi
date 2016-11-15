/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package envies;

import client.ContexteClient;

/**
 *
 * @author sylvain
 */
public class Comp_Regarder implements Comportement {

    public Comp_Regarder() {
    }

    @Override
    public String agir(ContexteClient c) {
        return "Je regarde";
    }

    public String toString() {
        return "Regarder";
    }
}
