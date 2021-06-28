<template>
  <div>
    <header class="h-12 shadow-md w-100">
      <div class="container mx-auto h-12 flex items-center">
        <h1 class="text-blue-500 text-lg">
          PayFlexi <span class="font-bold">Books</span>
        </h1>
      </div>
    </header>

    <main class="main-content mt-12">
      <div class="flex flex-col container mx-auto">
        <div class="bg-white shadow p-4 flex mb-4">
          <span class="w-auto flex justify-end items-center text-gray-500 p-2">
            <i class="material-icons text-3xl">search</i>
          </span>
          <input
            class="w-full rounded p-2 focus:outline-none focus:text-gray-500"
            type="text"
            placeholder="Try 'Author Name'"
            v-model="searchQuery"
            @keyup="handleSearch"
          />
          <button
            class="
              bg-gray-500
              hover:bg-gray-300
              rounded
              hover:text-black
              text-white
              p-2
              px-4
            "
            @click="handleSearch"
          >
            <p class="font-semibold text-xs">Search</p>
          </button>
        </div>
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div
            class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8"
          >
            <div
              class="
                shadow
                overflow-hidden
                border-b border-gray-200
                sm:rounded-lg
              "
            >
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                  <tr>
                    <th
                      scope="col"
                      class="
                        px-6
                        py-3
                        text-left text-xs
                        font-medium
                        text-gray-500
                        uppercase
                        tracking-wider
                      "
                      @click="sort('id')"
                    >
                      ID
                    </th>
                    <th
                      scope="col"
                      class="
                        px-6
                        py-3
                        text-left text-xs
                        font-medium
                        text-gray-500
                        uppercase
                        tracking-wider
                      "
                      @click="sort('name')"
                    >
                      Name
                    </th>
                    <th
                      scope="col"
                      class="
                        px-6
                        py-3
                        text-left text-xs
                        font-medium
                        text-gray-500
                        uppercase
                        tracking-wider
                      "
                      @click="sort('isbn')"
                    >
                      ISBN
                    </th>
                    <th
                      scope="col"
                      class="
                        px-6
                        py-3
                        text-left text-xs
                        font-medium
                        text-gray-500
                        uppercase
                        tracking-wider
                      "
                      @click="sort('authors')"
                    >
                      Author
                    </th>
                    <th
                      scope="col"
                      class="
                        px-6
                        py-3
                        text-left text-xs
                        font-medium
                        text-gray-500
                        uppercase
                        tracking-wider
                      "
                      @click="sort('country')"
                    >
                      Country
                    </th>
                    <th
                      scope="col"
                      class="
                        px-6
                        py-3
                        text-left text-xs
                        font-medium
                        text-gray-500
                        uppercase
                        tracking-wider
                      "
                      @click="sort('number_of_pages')"
                    >
                      Pages
                    </th>
                    <th
                      scope="col"
                      class="
                        px-6
                        py-3
                        text-left text-xs
                        font-medium
                        text-gray-500
                        uppercase
                        tracking-wider
                      "
                      @click="sort('publisher')"
                    >
                      Publisher
                    </th>
                    <th
                      scope="col"
                      class="
                        px-6
                        py-3
                        text-left text-xs
                        font-medium
                        text-gray-500
                        uppercase
                        tracking-wider
                      "
                      @click="sort('release_date')"
                    >
                      Release Date
                    </th>
                  </tr>
                </thead>
                <tbody
                  v-if="isLoading == false"
                  class="bg-white divide-y divide-gray-200"
                >
                  <tr v-for="(book, index) in filteredSearch" :key="index">
                    <td
                      class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                    >
                      {{ index + 1 }}
                    </td>
                    <td
                      class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                    >
                      {{ book.name }}
                    </td>
                    <td
                      class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                    >
                      {{ book.isbn }}
                    </td>
                    <td
                      class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                    >
                      {{ book.authors | string }}
                    </td>
                    <td
                      class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                    >
                      {{ book.country }}
                    </td>
                    <td
                      class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                    >
                      {{ book.number_of_pages }}
                    </td>
                    <td
                      class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                    >
                      {{ book.publisher }}
                    </td>
                    <td
                      class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                    >
                      {{ book.release_date }}
                    </td>
                  </tr>
                </tbody>
              </table>
              <loader v-if="isLoading"></loader>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>


<script>
export default {
  data() {
    return {
      isLoading: true,
      books: [],
      filteredSearch: [],
      searchQuery: "",
      sortBy: "",
      message: "",
      hasError: false,
    };
  },
  methods: {
    fetchBooks() {
      window.axios
        .get("/api/books")
        .then(({ status, data: { data: bookArray, message } }) => {
          this.message = message;
          if (status == 200) {
            this.books = bookArray;
            this.filteredSearch = bookArray;
          } else {
            this.hasError = true;
          }
        })
        .catch(({ response: { status } }) => {
          this.hasError = true;
          if (status == 404) {
            this.message =
              "Error Loading Books Please Contact Site Adminstrator";
          } else {
            this.message = "Uknown Error Occured";
          }
        })
        .finally((e) => {
          this.isLoading = false;
        });
    },
    sort(column) {
      const sortedField = this.sortBy;
      this.sortBy = column;
      // console.log(a[column], b[column]);
      this.books.sort((a, b) => {
        if (sortedField == column) {
          return a[column] > b[column] ? 1 : -1;
        } else {
          return a[column] > b[column] ? -1 : 1;
        }
      });
    },
    search() {
      console.log("now");

      this.filteredSearch = this.books.filter((arr) =>
        Object.values(arr).some((val) =>
          val ? val.toString().toLowerCase().includes(this.searchQuery) : false
        )
      );
    },

    debounce(func, timeout = 300) {
      let timer;
      return (...args) => {
        if (!timer) {
          func.apply(this, args);
        }
        clearTimeout(timer);
        timer = setTimeout(() => {
          timer = undefined;
        }, timeout);
      };
    },
    handleSearch() {
      this.debounce(this.search, 500)();
    },
  },
  created() {
    console.log("Created Dude: ", this.books);
    this.fetchBooks();
  },
  // watch: {
  //   sortBy: function (column) {
  //     this.books = this.books.sort((a, b) => {
  //       return a[column] > b[column] ? 1 : -1;
  //     });
  //   },
  // },
};
</script>

<style>
th {
  position: relative;
  cursor: pointer;
}
th::after {
  font-family: "Material Icons";
  content: "\e152";
  width: 20px;
  height: 20px;
  position: absolute;
  /* background: red; */
  top: 30%;
  right: 5%;
}
</style>