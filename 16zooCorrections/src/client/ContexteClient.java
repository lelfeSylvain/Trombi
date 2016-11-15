package client;

import kiosques.AbstractParcPosition;
import kiosques.IParcPosition;

/**
 *
 * @author sylvain
 */
public abstract class ContexteClient {

    private IParcPosition maPosition;

    public ContexteClient() {
        maPosition = new AbstractParcPosition();
    }

    public IParcPosition getMaPosition() {
        return maPosition;
    }

}
