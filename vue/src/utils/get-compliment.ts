import { getCompliments } from "./get-compliments";

export async function getCompliment(id: string) {
  const compliments = await getCompliments();
  return compliments!.filter((compliment) => compliment.id === id)![0];
}
