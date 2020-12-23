import { getCompliments } from "./get-compliments";

/** Fetches a random compliment from the dataset. */
export async function getRandomCompliment() {
  const compliments = (await getCompliments())!;
  return compliments[Math.floor(Math.random() * compliments.length)];
}
