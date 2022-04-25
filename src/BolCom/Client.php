<?php

namespace BolCom;

class Client
{
    private Request $request;

    /**
     * @param $token string Bol.com Open API access token
     * @param $useLegacyKey bool Use the legacy bol.com Open API token
     */
    public function __construct(string $token, bool $useLegacyKey = false)
    {
        $this->request = new Request($token, $useLegacyKey);
    }

    public function getPingResponse()
    {
        $httpResponse = $this->request->fetch('GET', '/utils/v4/ping/');

        if (!$httpResponse) $httpResponse = $this->request->getFullHeader();

        return $httpResponse;
    }

    public function getProduct($id, $queryParams = '')
    {
        $httpResponse = $this->request->fetch('GET', '/catalog/v4/products/' . $id . '/', $queryParams);

        if (!$httpResponse) $httpResponse = $this->request->getFullHeader();

        return $httpResponse;
    }

    public function getRecommendations($id, $queryParams = '')
    {
        $httpResponse = $this->request->fetch('GET', '/catalog/v4/recommendations/' . $id . '/', $queryParams);

        if (!$httpResponse) $httpResponse = $this->request->getFullHeader();

        return $httpResponse;
    }

    public function getRelatedProducts($id, $queryParams = '')
    {
        $httpResponse = $this->request->fetch('GET', '/catalog/v4/relatedproducts/' . $id . '/', $queryParams);

        if (!$httpResponse) $httpResponse = $this->request->getFullHeader();

        return $httpResponse;
    }

    public function getOffer($id, $queryParams = '')
    {
        $httpResponse = $this->request->fetch('GET', '/catalog/v4/offers/' . $id . '/', $queryParams);

        if (!$httpResponse) $httpResponse = $this->request->getFullHeader();

        return $httpResponse;
    }

    public function getLists($type, $ids, $offset, $limit, $sort, $sortingAscending, $includeProducts, $includeCategories, $includeRefinements, $includeAttributes = false, $listId = '')
    {
        $queryParams = '';
        $separator = '?';
        $separator2 = '';

        if (!empty($type)) {
            $queryParams .= $separator . 'type=' . urlencode($type);
            $separator = '&';
        }
        if (!empty($ids)) {
            $queryParams .= $separator . 'ids=' . urlencode($ids);
            $separator = '&';
        }
        if (!empty($includeAttributes)) {
            $queryParams .= $separator . 'includeattributes=' . urlencode($includeAttributes);
            $separator = '&';
        }
        if (!empty($offset)) {
            $queryParams .= $separator . 'offset=' . urlencode($offset);
            $separator = '&';
        }
        if (!empty($limit)) {
            $queryParams .= $separator . 'limit=' . urlencode($limit);
            $separator = '&';
        }
        if (!empty($sort) && !is_null($sortingAscending)) {
            $queryParams .= $separator . 'sort=' . urlencode($sort);
            $queryParams .= '&sortingAscending=' . (($sortingAscending) ? 'true' : 'false');
        }
        $queryParams .= $separator . 'dataoutput=';
        $separator = '&';
        if (!empty($includeProducts)) {
            $queryParams .= $separator2 . 'products';
            $separator2 = ',';
        }
        if (!empty($includeCategories)) {
            $queryParams .= $separator2 . 'categories';
            $separator2 = ',';
        }
        if (!empty($includeRefinements)) {
            $queryParams .= $separator2 . 'refinements';
            $separator2 = ',';
        }
        if (!empty($listId)) {
            $queryParams .= $separator . 'listId=' . urlencode($listId);
            $separator = '&';
        }
        $httpResponse = $this->request->fetch('GET', '/catalog/v4/lists/', $queryParams);

        if (!$httpResponse) $httpResponse = $this->request->getFullHeader();

        return $httpResponse;
    }

    public function getSearch($q, $ids, $pids, $offset, $limit, $sortingMethod, $sortingAscending, $includeProducts, $includeCategories, $includeAttributes, $offers = '', $searchfield = '')
    {
        $queryParams = '';
        $separator = '?';

        if (!empty($q)) {
            $queryParams .= $separator . 'q=' . urlencode($q);
            $separator = '&';
        }
        if (!empty($ids)) {
            $queryParams .= $separator . 'ids=' . urlencode($ids);
            $separator = '&';
        }
        if (!empty($includeAttributes)) {
            $queryParams .= $separator . 'includeattributes=' . urlencode($includeAttributes);
            $separator = '&';
        }
        if (!empty($offset)) {
            $queryParams .= $separator . 'offset=' . urlencode($offset);
            $separator = '&';
        }
        if (!empty($limit)) {
            $queryParams .= $separator . 'limit=' . urlencode($limit);
            $separator = '&';
        }
        if (!empty($sortingMethod) && !empty($sortingAscending)) {
            $queryParams .= $separator . 'sort=' . urlencode($sortingMethod);
            $queryParams .= '&sortingAscending=' . (($sortingAscending) ? 'true' : 'false');
        }
        if (!empty($offers)) {
            $queryParams .= $separator . 'offers=' . urlencode($offers);
        }
        if (!empty($searchfield)) {
            $queryParams .= $separator . 'searchfield=' . urlencode($searchfield);
        }
        if (!empty($pids)) {
            $queryParams .= $separator . 'pids=' . urlencode($pids);
        }
        $queryParams .= $separator . 'dataoutput=';
        if (!empty($includeProducts)) {
            $queryParams .= 'products';
            $separator = ',';
        }
        if (!empty($includeCategories)) {
            $queryParams .= $separator . 'categories';
            $separator = ',';
        }
        if (!empty($includeRefinements)) {
            $queryParams .= $separator . 'refinements';
            $separator = ',';
        }

        $httpResponse = $this->request->fetch('GET', '/catalog/v4/search/', $queryParams);

        if (!$httpResponse) $httpResponse = $this->request->getFullHeader();

        return $httpResponse;
    }

    public function addToBasket($id, $quantity = 0, $ipAddress = 0)
    {
        $httpResponse = $this->request->fetch('POST', '/checkout/v4/baskets/' . $id . '/' . $quantity . '/' . $ipAddress);

        if (!$httpResponse) $httpResponse = $this->request->getFullHeader();

        return $httpResponse;
    }

    public function getBasket()
    {
        $httpResponse = $this->request->fetch('GET', '/checkout/v4/baskets/');

        if (!$httpResponse) $httpResponse = $this->request->getFullHeader();


        return $httpResponse;
    }

    public function updateQuantityBasket($basketItemId, $quantity)
    {
        $httpResponse = $this->request->fetch('PUT', '/checkout/v4/baskets/' . $basketItemId . '/' . $quantity . '/');

        if (!$httpResponse) $httpResponse = $this->request->getFullHeader();

        return $httpResponse;
    }

    public function removeFromBasket($basketItemId)
    {
        $httpResponse = $this->request->fetch('DELETE', '/checkout/v4/baskets/' . $basketItemId . '/');

        if (!$httpResponse) $httpResponse = $this->request->getFullHeader();

        return $httpResponse;
    }


    public function getAuthToken($successUrl = null, $errorUrl = null)
    {
        $httpResponse = $this->request->fetch('POST', '/accounts/v4/authtokens', '?successurl=' . $successUrl . '&errorurl=' . $errorUrl);

        if (!$httpResponse) $httpResponse = $this->request->getFullHeader();

        return $httpResponse;
    }

    public function getlogin($privatetoken = null)
    {
        $httpResponse = $this->request->fetch('POST', '/accounts/v4/login', '?privatetoken=' . $privatetoken);

        if (!$httpResponse) $httpResponse = $this->request->getFullHeader();

        return $httpResponse;
    }

    public function getWishlist()
    {
        $httpResponse = $this->request->fetch('GET', '/accounts/v4/wishlists/');

        if (!$httpResponse) $httpResponse = $this->request->getFullHeader();

        return $httpResponse;
    }

    public function postWishlist($productId)
    {
        $httpResponse = $this->request->fetch('POST', '/accounts/v4/wishlists/' . $productId . '/');

        if (!$httpResponse) $httpResponse = $this->request->getFullHeader();

        return $httpResponse;
    }

    public function deleteWishlist($wishListItemId)
    {
        $httpResponse = $this->request->fetch('DELETE', '/accounts/v4/wishlists/' . $wishListItemId . '/');

        if (!$httpResponse) $httpResponse = $this->request->getFullHeader();

        return $httpResponse;
    }

    /**
     * @deprecated Use setReferrer instead
     */
    public function setRefferer($referrerCode = null)
    {
        return $this->setReferrer($referrerCode);
    }

    public function setReferrer($referrerCode = null)
    {
        $httpResponse = $this->request->fetch('PUT', '/checkout/v4/referrers/' . $referrerCode . '/');

        if (!$httpResponse) $httpResponse = $this->request->getFullHeader();

        return $httpResponse;
    }

    public function setSessionId($sessionid)
    {
        $this->request->setSessionId($sessionid);
    }

    public function getSessionId()
    {
        $httpResponse = $this->request->fetch('GET', '/accounts/v4/sessions/');

        if (!$httpResponse) $httpResponse = $this->request->getFullHeader();

        return $httpResponse;
    }

    public function getFullHeader()
    {
        return $this->request->getFullHeader();
    }

}
