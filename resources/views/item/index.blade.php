<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Items</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css"  rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <div class="bg-gray-100 text-gray-800">
        <div
            x-data="{
                items: null,
                itemName: '',
                showForm: false,
                showEdit: false,
                async fetchItems() {
                    try {
                        const response = await axios.get('/api/items');
                        this.items = response.data.items;
                        console.log(this.items);
                    } catch(error) {
                        console.error('Error fetching:', error);
                    }
                },
                toggleForm() {
                    this.showForm = !this.showForm;
                    this.itemName = '';
                },
                toggleEdit(item) {
                    this.showEdit = true ;
                    this.showForm = false;
                    this.currentItemId = item.id;
                    this.itemName = item.name;
                },
                async createItem() {
                    if (!this.itemName.trim()) return alert('Item name is required');
                    try {
                        const response = await axios.post('/api/items', { name: this.itemName});
                        this.items.push(response.data);
                        this.toggleForm();
                        alert('Item created successfully');
                    }
                    catch (error) {
                        console.error('Error creating item:', error);
                    }
                },
                async editItem() {
                    if (!this.itemName.trim()) return alert('Item name is required');
                    try {
                        const response = await axios.put(`/api/items/${this.currentItemId}`, {name: this.itemName});
                        const updatedItem = response.data;
                        this.items = this.items.map(item => item.id === this.currentItemId ? updatedItem : item);
                        this.showEdit = false;
                        this.itemName = '';
                        alert('Item edited successfully!');
                    } catch (error) {
                        console.error('Error editing item:', error);
                    }
                },
                deleteItem(id) {
                    if (confirm('Are you sure you want to delete this item?'))  {
                        axios.delete(`api/items/${id}`)
                            .then(() => {
                                this.items = this.items.filter(item => item.id !== id);
                                alert('Item deleted successfully!');
                            })
                            .catch(error => console.error('Error deleting item:', error));
                    }
                }
            }"˜
            x-init="fetchItems"
            class="container mx-auto px-4 py-8"
        >
            <h1 class="text-2xl font-semibold text-center mb-6 text-gray-700">Item List App</h1>

            <div class="flex justify-end mb-4">
                <button @click="toggleForm" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    <span x-show="!showForm">Create New Item</span>
                    <span x-show="showForm">Back to List</span>
                </button>
            </div>

            <div x-show="showForm" class="mb-6">
                <h2 class="text-xl font-semibold text-gray-600 mb-4">Create New Item</h2>
                <div class="bg-white shadow-sm rounded px-8 pt-6 pb-8 mb-4">
                    <label for="item-name" class="block text-gray-700 text-sm font-bold mb-2">Item Name</label>
                    <input type="text" id="item-name" x-model="itemName" placeholder="Enter item name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-4">
                    <button @click="createItem" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Create Item</button>
                </div>
            </div>

            <div x-show="showEdit" class="mb-6">
                <h2 class="text-xl font-semibold text-gray-600 mb-4">Edit Item</h2>
                <div class="bg-white shadow-sm rounded px-8 pt-6 pb-8 mb-4">
                    <label for="item-name" class="block text-gray-700 text-sm font-bold mb-2">Item Name</label>
                    <input type="text" id="edit-item-name" x-model="itemName" placeholder="Enter item name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline mb-4">
                    <button @click="editItem" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-green-600">Edit Item</button>
                    <button @click="showEdit = false; itemName = '';" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-green-600">Cancel</button>
                </div>
            </div>

            <div x-show="!showForm && !showEdit" class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-white uppercase bg-gray-500 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Item ID
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="item in items" :key="item.id">
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td x-text="item.id" class="px-6 py-4"></td>
                                <td x-text="item.name" class="px-6 py-4"></td>
                                <td class="px-6 py-4 space-x-2">
                                    <button @click="toggleEdit(item)" class="text-blue-600 hover:underlined">Edit</button>
                                    <button @click="deleteItem(item.id)" class="text-red-600">Delete</button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</body>
</html>
