<template>
  <div class="min-h-screen bg-white text-white flex items-center justify-center">
    <div class="text-center space-y-4">
       <h1 class="text-4xl font-semibold bg-gradient-to-br from-cyan-500 to-blue-500 bg-clip-text text-transparent">
  Welcome to Laura-Belle
</h1>
 <div class="space-y-2 flex flex-col items-center mt-10">
<div class="w-full p-[1px] rounded-md bg-gradient-to-br from-cyan-500 to-blue-500 focus-within:from-blue-500 focus-within:to-cyan-700">
  <input 
    v-model="email" 
    placeholder="Email@gmail.com" 
    class="w-full px-2 py-2 rounded-md text-black bg-white outline-none"
  />
</div>



<div class="w-full p-[1px] rounded-md bg-gradient-to-br from-cyan-500 to-blue-500 focus-within:from-blue-500 focus-within:to-cyan-700 mt-2">
  <input 
    v-model="password" 
    placeholder="*********" 
    class="w-full px-2 py-2 rounded-md text-black bg-white outline-none"
  />
</div>
  <span -v-if="emailError" class="text-red-500 text-sm mt-1">{{ emailError }}</span>
  <span -v-if="passwordError" class="text-red-500 text-sm mt-1">{{ passwordError }}</span>
<div class="flex justify-between w-full mt-2 text-sm text-gray-500">
    <a href="#" class="hover:underline">Remember Me</a>
    <a href="#" class="hover:underline">Forgot Password?</a>
</div>
       <!-- From Uiverse.io by zymantas-katinas --> 
<button @click="validateInputs"
  class="relative group border-none bg-transparent p-0 outline-none cursor-pointer font-mono font-light uppercase text-base"
>
  <span
    class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-25 rounded-lg transform translate-y-0.5 transition duration-[600ms] ease-[cubic-bezier(0.3,0.7,0.4,1)] group-hover:translate-y-1 group-hover:duration-[250ms] group-active:translate-y-px"
  ></span>

  <span
    class="absolute top-0 left-0 w-full h-full rounded-lg bg-gradient-to-l from-[hsl(217,33%,16%)] via-[hsl(217,33%,32%)] to-[hsl(217,33%,16%)]"
  ></span>

  <div
    class="relative flex items-center justify-between py-3 px-6 text-lg text-white rounded-lg transform -translate-y-1 bg-gradient-to-r from-[#f27121] via-[#e94057] to-[#8a2387] gap-3 transition duration-[600ms] ease-[cubic-bezier(0.3,0.7,0.4,1)] group-hover:-translate-y-1.5 group-hover:duration-[250ms] group-active:-translate-y-0.5 brightness-100 group-hover:brightness-110"
  >
    <span class="select-none">Submit</span>

    <svg
      viewBox="0 0 20 20"
      fill="currentColor"
      class="w-5 h-5 ml-2 -mr-1 transition duration-250 group-hover:translate-x-1"
    >
      <path
        clip-rule="evenodd"
        d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
        fill-rule="evenodd"
      ></path>
    </svg>
  </div>
</button>

       </div>
      
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: "",
      password: "",
      emailError: "",
      passwordError: ""
    };
  },
  methods: {
    validateInputs() {
      // Reset errors
      this.emailError = "";
      this.passwordError = "";

      // Email validation
      if (!this.email.includes("@gmail.com")) {
        this.emailError = "Email must be a Gmail address.";
        // alert(this.emailError);
      }

      // Password validation
      const passwordRegex = /^(?=.*[A-Z])(?=.*\d).{8,}$/;
      if (!passwordRegex.test(this.password)) {
        this.passwordError = "Password must be at least 8 characters, include 1 uppercase letter and 1 number.";
      }
    }
  }
};
</script>