<script setup></script>

<template>
	<div>
		<h4 class="text-gray-600 dark:text-slate-100 text-lg font-medium">
			<slot name="title" />
		</h4>
		<p class="text-sm leading-normal text-gray-600 dark:text-slate-400 mt-1">
			<slot name="content" />
		</p>
	</div>
</template>
