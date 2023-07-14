<?php

namespace App\Controller;

use App\Enum\TypeFlat;
use App\Enum\Status;
use App\Entity\OfferItems;
use App\Entity\Offers;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use DateTimeImmutable;
use DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends AbstractController
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/api/v1/offer/new", name="offer_new", methods={"POST"})
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function newOffer(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        if (!$data) {
            $responseData = [
                'status' => 422,
                'description' => "Data not valid",
            ];
            return new JsonResponse($responseData, 422);
        }
        $offer = new Offers();
        $now = new DateTime();
        $expires = new \DateTime('+7 days');
        $entityManager = $doctrine->getManager();
        $offersRepository = $entityManager->getRepository(Offers::class);

        $offer->setB24ContactId($data['b24_contact_id']);
        $offer->setB24DealId($data['b24_deal_id']);
        $offer->setB24ManagerId($data['b24_manager_id']);
        $offer->setManager($data['manager']);
        $offer->setPosition($data['position']);
        $offer->setPhone($data['phone']);
        $offer->setAvatar($data['avatar']);
        $offer->setStatus(1);
        $offer->setCreateAt($now);
        $offer->setDate_end($data['date_end'] ?? $expires);

        $offersRepository->save($offer);

        $responseData = [
            'status'      => 200,
            'id'          => $offer->getId(),
            'description' => 'Created new offer successfully with id ' . $offer->getId(),
        ];
        return new JsonResponse($responseData, 200);
    }

    /**
     * @Route("/api/v1/offer/update/{id}", name="offer_update", methods={"PUT"}, requirements={"id"="\d+"})
     * @param int $id
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function updateOffer(int $id, Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);
        if (!$data) {
            $responseData = [
                'status' => 422,
                'description' => "Data not valid",
            ];
            return new JsonResponse($responseData, 422);
        }
        if (!$id) {
            $responseData = [
                'status'      => 404,
                'description' => "Unknown offer ID. Failed to update",
            ];
            return new JsonResponse($responseData, 404);
        }
        $entityManager = $doctrine->getManager();
        $offersRepository = $entityManager->getRepository(Offers::class);
        $offer = $offersRepository->find($id);
        if (!$offer){
            $responseData = [
                'status'      => 404,
                'description' => "No offer found for ID $id. Failed to update",
            ];
            return new JsonResponse($responseData, 404);
        }
        $offer->setB24ContactId($data['b24_contact_id'] ?? $offer->getB24ContactId());
        $offer->setB24DealId($data['b24_deal_id'] ?? $offer->getB24DealId());
        $offer->setB24ManagerId($data['b24_manager_id'] ?? $offer->getB24ManagerId());
        $offer->setManager($data['manager'] ?? $offer->getManager());
        $offer->setPosition($data['position'] ?? $offer->getPosition());
        $offer->setAvatar($data['avatar'] ?? $offer->getAvatar());
        $offer->setStatus(Status::FromString($data['status'])->value);
        $offer->setDate_end($data['date_end'] ?? $offer->getDate_end());

        $offersRepository->save($offer);
        $responseData = [
            'status'      => 200,
            'id'          => $offer->getId(),
            'description' => "Offer with ID $id was successfully updated",
        ];
        return new JsonResponse($responseData, 200);
    }

    /**
     * @Route("/api/v1/offer_item/new", name="offer_item_new")
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function newOfferItem(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        if (!$data) {
            $responseData = [
                'status'      => 422,
                'description' => "Data not valid",
            ];
            return new JsonResponse($responseData, 422);
        }

        if (!$data['offer_id']) {
            $responseData = [
                'status'      => 404,
                'description' => "Offer ID not set. Failed to add item to unknown offer",
            ];
            return new JsonResponse($responseData, 404);
        }
        $offer_id = $data['offer_id'];
        $entityManager = $doctrine->getManager();
        $offerRepository = $entityManager->getRepository(Offers::class);
        $offer = $offerRepository->find($data['offer_id']);

        if (!$offer) {
            $responseData = [
                'status'      => 404,
                'offer_id'    => $offer_id,
                'description' => "No offer found for ID: $offer_id. Failed to add item to unknown offer",
            ];
            return new JsonResponse($responseData, 404);
        }
        if ($offer->getStatus() !== Status::New) {
            $offerStatus = Status::from($offer->getStatus())->name;
            $responseData = [
                'status'      => 412,
                'offer_id'    => $offer_id,
                'offer_status'=> $offerStatus,
                'description' => "Unacceptable offer status: $offerStatus. Failed to add item to the offer",
            ];
            return new JsonResponse($responseData, 404);
        }

        $item = new OfferItems();
        $itemRepository = $entityManager->getRepository(OfferItems::class);

        $item->setOfferId($offer);
        $item->setCid($data['cid']);
        $item->setType(TypeFlat::FromString($data['type'])->value);
        $item->setSquare($data['square']);
        $item->setComplex($data['complex'] ?? '');
        $item->setHouse($data['house']);
        $item->setDescription($data['description'] ?? '');
        $item->setImages($data['images'] ?? '');
        $item->setLike(false);

        $itemRepository->save($item);

        $responseData = [
            'status'      => 200,
            'id'          => $item->getId(),
            'offer_id'    => $offer->getId(),
            'description' => 'Created new offer item successfully with id ' . $item->getId(),
        ];
        return new JsonResponse($responseData, 200);

    }

    /**
     * @Route("/api/v1/offer_item/delete/{id}", name="offer_item_delete", methods={"DELETE"}, requirements={"id"="\d+"})
     * @param int $id
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function deleteOfferItem (int $id, Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        if (!$id) {
            $responseData = [
                'status'      => 400,
                'description' => "Unknown offer ID. Failed to update",
            ];
            return new JsonResponse($responseData, 404);
        }
        $entityManager = $doctrine->getManager();
        $offerItemsRepository = $entityManager->getRepository(OfferItems::class);
        $item = $offerItemsRepository->find($id);
        if (!$item) {
            $responseData = [
                'status'      => 404,
                'description' => "No item found for ID $id. Failed to delete",
            ];
            return new JsonResponse($responseData, 404);
        }
        $item_id = $item->getId();
        $offerItemsRepository->delete($item);
        $entityManager->flush();

        $responseData = [
            'status'      => 200,
            'id'          => $item_id,
            'description' => "Item with ID $id was successfully deleted",
        ];
        return new JsonResponse($responseData, 200);
    }
}
