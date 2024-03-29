<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 */
class OrdersController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {

       
        $orders = $this->Orders->find('all')
            -> where (['complete' => '0']);
        
        $this->set('orders', $orders);
        $this->set('_serialize', ['orders']);
               
        $CompleteOrders = $this->Orders->find('all')
            -> where (['complete' => '1']);
        
         $this->set('CompleteOrders', $CompleteOrders);
         $this->set('_serialize', ['$CompleteOrders']);
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => []
        ]);
        $this->set('order', $order);
        $this->set('_serialize', ['order']);
       /* $order = $this->Orders->get($id);
        $this->set(compact('article'));*/
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $order = $this->Orders->newEntity();
        if ($this->request->is('post')) {
            $order = $this->Orders->patchEntity($order, $this->request->data);
            $order->user_id = $this->Auth->user('id');
            //to do sth with topping parsing  
            if ($this->Orders->save($order)) {
                
                $this->Flash->success(__('The order has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The order could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('order'));
        $this->set('_serialize', ['order']);
    }

    public function Complete($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => []
        ]);
        
        //$order = $this->Orders->get($id); 
        $order->Complete= '1';
            $this->Orders->save($order);
      
                $this->Flash->success(__('The order has been completed.'));
                return $this->redirect(['action' => 'index']);
        }


    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $order = $this->Orders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $order = $this->Orders->patchEntity($order, $this->request->data);
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The order could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('order'));
        $this->set('_serialize', ['order']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        if ($this->Orders->delete($order)) {
            $this->Flash->success(__('The order has been deleted.'));
        } else {
            $this->Flash->error(__('The order could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function isAuthorized($user)
    {
        // All registered users can add articles
        if ($this->request->action === 'add') {
            return true;
        }

        // The owner of an article can edit and delete it
        if (in_array($this->request->action, ['edit', 'delete', 'Complete'])) {
            $orderId = (int)$this->request->params['pass'][0];
            if ($this->Orders->isOwnedBy($orderId, $user['id'])) {
                return true;
            }
        }

        return parent::isAuthorized($user);
    }
    public function isOwnedBy($orderId, $userId)
    {
        return $this->exists(['id' => $orderId, 'user_id' => $userId]);
    }


    

}
