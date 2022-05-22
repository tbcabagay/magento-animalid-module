# magento-animalid-module
Magento 2 Animalid Module

![banner](https://raw.githubusercontent.com/tbcabagay/magento-animalid-module/0a6cda1544e48255db4d5e6642d72ddab413cd32/banner.png)

## The test requirements
This is only the Magento 2 module which contains the dropdown list that allows a customer to change the animal photo.

When the page initially loads, the default animal photo is the cat.

### Sample screenshots
1. Cat
    - ![cat](https://raw.githubusercontent.com/tbcabagay/magento-animalid-module/main/cat.png)
2. Dog
    - ![dog](https://raw.githubusercontent.com/tbcabagay/magento-animalid-module/main/dog.png)
3. Llama
    - ![llama](https://raw.githubusercontent.com/tbcabagay/magento-animalid-module/main/llama.png)
4. Anteater
    - ![anteater](https://raw.githubusercontent.com/tbcabagay/magento-animalid-module/main/anteater.png)


## Extra credit
When the customer selects a photo, the change persists in the session storage. Refreshing the page will display the previously selected animal photo.

```
<?php
namespace Razoyo\AnimalProfile\Controller\Profile\Photo.php

// Takes the data from the AJAX request. Throws an \Exception if the value is invalid. Then saves the value in the customer session.
private function getSelectedAnimalIdType()
{
    $param = $this->getRequest()->getParam('animalIdType');
    switch ($param) {
        case 'cat':
            $photo = new Animal\Cat();
            break;
        case 'dog':
            $photo = new Animal\Dog();
            break;
        case 'llama':
            $photo = new Animal\Llama();
            break;
        case 'anteater':
            $photo = new Animal\Anteater();
            break;
        default:
            throw new \Exception('The animalid type is invalid.');
            break;
    }
    $this->customerSession->setAnimalidPhoto($param);
    return $photo;
}
```

```
namespace Razoyo\AnimalProfile\Block\Profile\View.php;

// Gets the session value to be passed to the view object.
public function getPhotoFromSession()
{
    return $this->customerSession->getAnimalidPhoto() ?
        $this->customerSession->getAnimalidPhoto() : 'cat';
}
?>
```
