import type { Compliment } from "@/models/compliment";

const complimentsId = "compliments";

/** Gets all of the compliments from the dataset. */
export async function getCompliments() {
  let compliments = sessionStorage.getItem(complimentsId);  
  if (compliments === null) {
    const res = await fetch(`${window.location.origin}/compliments.json`);
    const data = await res.json();
    sessionStorage.setItem(complimentsId, JSON.stringify(data));
    return data as Compliment[];
  } else if (typeof compliments === "string") {
    return JSON.parse(compliments) as Compliment[];
  }
  throw Error("Unable to get compliments.");
}
